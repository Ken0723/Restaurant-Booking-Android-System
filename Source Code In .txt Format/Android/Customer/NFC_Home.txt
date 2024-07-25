package com.example.fyp;

import android.app.PendingIntent;
import android.content.Intent;
import android.content.IntentFilter;
import android.icu.text.UnicodeSetSpanner;
import android.nfc.NdefMessage;
import android.nfc.NdefRecord;
import android.nfc.NfcAdapter;
import android.os.Bundle;
import android.os.Parcelable;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;
import androidx.appcompat.app.AppCompatActivity;
import java.io.UnsupportedEncodingException;
import java.util.ArrayList;

public class NFC_Home extends AppCompatActivity {

    private Customer customer;
    private String firstName, lastName, email, id, phone ,address, password;
    private NfcAdapter nfcAdapter;
    private Button btnScan, btnStart, btnCallWaiter, btnViewAllOrderedFood, btnOrderFood;
    private TextView tvReservationId, tvReservationDate, tvReservationTime, tvRestaurantId, tvCustomerName, tvTotalTime;
    private Reservation reservation;

    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.nfc_home);

        firstName = getIntent().getStringExtra("firstName");
        lastName = getIntent().getStringExtra("lastName");
        email = getIntent().getStringExtra("email");
        password = getIntent().getStringExtra("password");
        id  = getIntent().getStringExtra("id");
        phone = getIntent().getStringExtra("phone");
        address = getIntent().getStringExtra("address");

        btnScan = findViewById(R.id.btnScan);
        btnStart = findViewById(R.id.btnStart);
        btnCallWaiter = findViewById(R.id.btnCallWaiter);
        btnViewAllOrderedFood = findViewById(R.id.btnViewOrderedFood);
        btnOrderFood = findViewById(R.id.btnOrderFood);
        tvReservationDate = findViewById(R.id.tvReservationDate);
        tvReservationId = findViewById(R.id.tvReservationId);
        tvReservationTime = findViewById(R.id.tvReservationTime);
        tvCustomerName = findViewById(R.id.tvCustomerName);
        tvRestaurantId = findViewById(R.id.tvRestaurantId);
        tvTotalTime = findViewById(R.id.tvTotalTime);

        customer = new Customer(id, firstName, lastName, email, password, phone, address);
        nfcAdapter = NfcAdapter.getDefaultAdapter(this);

        btnScan.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Toast.makeText(NFC_Home.this, "Please put your phone to the table!", Toast.LENGTH_LONG).show();
                btnScan.setEnabled(false);
            }
        });
        tvCustomerName.setText(customer.getLastName() + " " +customer.getFirstName());
        isStartingReservation();
    }
    protected void onResume() {
        super.onResume();
        enableForegroundDispatchSystem();
    }
    protected void onPause() {
        super.onPause();
        disableForegroundDispatchSystem();
    }
    protected void onNewIntent(Intent intent) {
        super.onNewIntent(intent);
        if (intent.hasExtra(NfcAdapter.EXTRA_TAG)) {
            if (!btnScan.isEnabled()) {
                Toast.makeText(this, "NfcIntent!", Toast.LENGTH_SHORT).show();
                Parcelable[] parcelables = intent.getParcelableArrayExtra(NfcAdapter.EXTRA_NDEF_MESSAGES);
                if (parcelables != null && parcelables.length > 0) {
                    readNfc((NdefMessage) parcelables[0]);
                }
            }
        }
    }
    private void enableForegroundDispatchSystem() {
        Intent intent = new Intent(this, NFC_Home.class).addFlags(Intent.FLAG_RECEIVER_REPLACE_PENDING);

        PendingIntent pendingIntent = PendingIntent.getActivity(this, 0, intent, 0);

        IntentFilter[] intentFilters = new IntentFilter[]{};

        nfcAdapter.enableForegroundDispatch(this, pendingIntent, intentFilters, null);
    }
    private void disableForegroundDispatchSystem() {
        nfcAdapter.disableForegroundDispatch(this);
    }
    private void readNfc(NdefMessage ndefMessage) {
        NdefRecord[] ndefRecords = ndefMessage.getRecords();
        if (ndefRecords != null && ndefRecords.length > 0) {
            NdefRecord ndefRecord = ndefRecords[0];
            String tagData = getTextFromNdefRecord(ndefRecord);
            NfcVerification(customer, tagData);
        }
    }
    private void NfcVerification(final Customer customer, String data) {
        ServerRequests serverRequests = new ServerRequests(this);
        serverRequests.NfcChecking(customer, data, new GetOwnReservationCallBack() {
            @Override
            public void done(Reservation returnedReservation) {
                if (returnedReservation != null) {
                    btnScan.setEnabled(false);
                    btnStart.setEnabled(true);
                    setReservationInfo(returnedReservation);
                } else {
                    btnScan.setEnabled(true);
                    Toast.makeText(NFC_Home.this, "Cannot find any reservation,\nPlease contact the staff", Toast.LENGTH_LONG).show();
                }
            }
        });
    }
    public void setReservationInfo(Reservation reservationInfo) {
        tvCustomerName.setText("Customer name: " + customer.getLastName() + " " +customer.getFirstName());
        tvRestaurantId.setText("Restaurant Id: " + reservationInfo.getRestaurantID());
        tvReservationDate.setText("Reservation date: " + reservationInfo.getDate());
        tvReservationTime.setText("Reservation time: " + reservationInfo.getTime());
        tvReservationId.setText("Reservation id: " + reservationInfo.getReservationID());
        tvTotalTime.setText("Total time: 150 mins");
        reservation = reservationInfo;
    }
    public void onClickCallWaiter(View v) {
        ServerRequests serverRequests = new ServerRequests(this);
        serverRequests.callWaiter(reservation, new CallWaiterCallBack() {
            @Override
            public void done(Boolean isSuccess) {
                if (isSuccess) {
                    Toast.makeText(NFC_Home.this, "Completed, please wait.", Toast.LENGTH_SHORT).show();
                } else {
                    Toast.makeText(NFC_Home.this, "Fail to call waiter.\nPlease try again", Toast.LENGTH_SHORT).show();
                }
            }
        });
    }
    public void onClickOrderFood(View v) {
        Dialog_OrderFood dialog_orderFood = new Dialog_OrderFood();
        dialog_orderFood.getData(customer, reservation);
        dialog_orderFood.show(getSupportFragmentManager(), "Order Food");
    }
    public void onClickViewAllOrderedFood(View v) {
        ServerRequests serverRequests = new ServerRequests(this);
        serverRequests.getAllOrderID(reservation, new GetAllOrderIDCallBack() {
            @Override
            public void done(ArrayList<Order> orderedFoodArrayList) {
                if (orderedFoodArrayList != null) {
                    Dialog_AllOrderedFood dialog_allOrderedFood = new Dialog_AllOrderedFood();
                    dialog_allOrderedFood.getData(orderedFoodArrayList);
                    dialog_allOrderedFood.show(getSupportFragmentManager(), "All ordered food");
                } else {
                    Log.e("No data", orderedFoodArrayList.size() + "");
                }
            }
        });
    }
    public void isStartingReservation() {
        ServerRequests serverRequests = new ServerRequests(this);
        serverRequests.isStartingReservation(customer, new GetStartingReservationCallBack() {
            @Override
            public void done(Reservation returnedReservation) {
                if (returnedReservation == null) {
                    btnScan.setEnabled(true);
                    btnCallWaiter.setEnabled(false);
                    btnOrderFood.setEnabled(false);
                    btnViewAllOrderedFood.setEnabled(false);
                    btnStart.setEnabled(false);
                } else {
                    btnScan.setEnabled(false);
                    btnCallWaiter.setEnabled(true);
                    btnOrderFood.setEnabled(true);
                    btnViewAllOrderedFood.setEnabled(true);
                    btnStart.setEnabled(false);
                    setReservationInfo(returnedReservation);
                }
            }
        });
    }
    public void onClickStart(View v) {
        ServerRequests serverRequests = new ServerRequests(this);
        serverRequests.startReservation(reservation, new StartReservationCallBack() {
            @Override
            public void done(Boolean isSuccess) {
                if (isSuccess) {
                    btnScan.setEnabled(false);
                    btnCallWaiter.setEnabled(true);
                    btnOrderFood.setEnabled(true);
                    btnViewAllOrderedFood.setEnabled(true);
                    btnStart.setEnabled(false);
                    Toast.makeText(NFC_Home.this, "The reservation starting, now you remaining 150 mins.", Toast.LENGTH_SHORT).show();
                } else {
                    Toast.makeText(NFC_Home.this, "Cannot start this reservation.\nPlease try again or contact our staff.", Toast.LENGTH_SHORT).show();
                }
            }
        });
    }
    public String getTextFromNdefRecord(NdefRecord ndefRecord) {
        String data = null;
        try {
            byte[] payload = ndefRecord.getPayload();
            // Get the text encoding
            String textEncoding = ((payload[0] & 128) == 0) ? "UTF-8" : "UTF-16";
            // Get the language code
            int languageSzie = payload[0] & 0063;
            // Get the text and save to data
            data = new String (payload, languageSzie + 1, payload.length - languageSzie - 1, textEncoding);
        } catch (UnsupportedEncodingException e) {
            Log.e("Nfc exception: ", e.getMessage(), e);
        }
        return data;
    }
    public void onClickBooking(View v) {
        this.finish();
        Intent intent = new Intent(NFC_Home.this, Booking.class);
        intent.putExtra("firstName", customer.firstName);
        intent.putExtra("lastName", customer.lastName);
        intent.putExtra("email", customer.email);
        intent.putExtra("password", customer.password);
        intent.putExtra("id", customer.accID);
        intent.putExtra("phone", customer.phone);
        intent.putExtra("address", customer.address);
        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
        startActivity(intent);
    }
    public void onClickMenu(View v) {
        this.finish();
        Intent intent = new Intent(NFC_Home.this, Menu.class);
        intent.putExtra("firstName", customer.firstName);
        intent.putExtra("lastName", customer.lastName);
        intent.putExtra("email", customer.email);
        intent.putExtra("password", customer.password);
        intent.putExtra("id", customer.accID);
        intent.putExtra("phone", customer.phone);
        intent.putExtra("address", customer.address);
        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
        startActivity(intent);
    }
    public void onClickAccount(View v) {
        this.finish();
        Intent intent = new Intent(NFC_Home.this, Account.class);
        intent.putExtra("firstName", customer.firstName);
        intent.putExtra("lastName", customer.lastName);
        intent.putExtra("email", customer.email);
        intent.putExtra("id", customer.accID);
        intent.putExtra("password", customer.password);
        intent.putExtra("phone", customer.phone);
        intent.putExtra("address", customer.address);
        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
        startActivity(intent);
    }
    public void onClickNews(View v) {
        this.finish();
        Intent intent = new Intent(NFC_Home.this, News.class);
        intent.putExtra("firstName", customer.firstName);
        intent.putExtra("lastName", customer.lastName);
        intent.putExtra("email", customer.email);
        intent.putExtra("id", customer.accID);
        intent.putExtra("password", customer.password);
        intent.putExtra("phone", customer.phone);
        intent.putExtra("address", customer.address);
        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
        startActivity(intent);
    }
}
