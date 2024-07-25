package com.example.fyp;

import android.content.Intent;
import android.nfc.NfcAdapter;
import android.os.Bundle;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;
import androidx.appcompat.app.AppCompatActivity;
import java.util.ArrayList;

public class All_Reservation  extends AppCompatActivity {

    private ArrayList<Reservation> reservationArrayList;
    private Reservation reservation;
    private String firstName, lastName, email, id, phone, address, password;
    private Customer customer;
    private ListView lvReservation;
    private NfcAdapter nfcAdapter;

    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.all_reservation);

        firstName = getIntent().getStringExtra("firstName");
        lastName = getIntent().getStringExtra("lastName");
        email = getIntent().getStringExtra("email");
        password = getIntent().getStringExtra("password");
        id = getIntent().getStringExtra("id");
        phone = getIntent().getStringExtra("phone");
        address = getIntent().getStringExtra("address");

        customer = new Customer(id, firstName, lastName, email, password, phone, address);

        lvReservation = findViewById(R.id.lvReservation);
        nfcAdapter = NfcAdapter.getDefaultAdapter(this);
        getAllReservation(customer);
    }
    protected void onStart() {
        super.onStart();
        if (email == null && email.length() < 1) {
            Toast.makeText(this, "Sorry, there are error, please login again.", Toast.LENGTH_LONG).show();
            startActivity(new Intent(All_Reservation.this, Login.class));
        }
    }
    public void getAllReservation(Customer customer) {
        ServerRequests serverRequests = new ServerRequests(this);
        serverRequests.getAllReservationByID(customer, new GetReservationCallBack() {
            @Override
            public void done(ArrayList reservationArray) {
                if (reservationArray != null) {
                    reservationArrayList = reservationArray;
                    addItemToListView();
                } else {
                    Toast.makeText(getApplicationContext(), "Cannot get the reservation, please login again!", Toast.LENGTH_SHORT).show();
                }
            }
        });
    }
    public void addItemToListView() {
        ReservationAdapter reservationAdapter = new ReservationAdapter();
        lvReservation.setAdapter(reservationAdapter);
    }
    public class ReservationAdapter extends BaseAdapter {

        @Override
        public int getCount() {
            return reservationArrayList.size();
        }

        @Override
        public Object getItem(int position) {
            return null;
        }

        @Override
        public long getItemId(int position) {
            return 0;
        }

        @Override
        public View getView(int position, View convertView, ViewGroup parent) {
            convertView = getLayoutInflater().inflate(R.layout.view_reservation, null);

            TextView tvReservationID = convertView.findViewById(R.id.tvReservationID);
            TextView tvRestaurantID = convertView.findViewById(R.id.tvRestaurantId);
            TextView tvTableID = convertView.findViewById(R.id.tvTableID);
            TextView tvReservationDate = convertView.findViewById(R.id.tvReservationDate);
            TextView tvReservationTime = convertView.findViewById(R.id.tvReservationTime);
            TextView tvStatus = convertView.findViewById(R.id.tvStatus);
            Button btnCancel = convertView.findViewById(R.id.btnCancel);
            Button btnPay = convertView.findViewById(R.id.btnFinishPayment);

            reservation = reservationArrayList.get(position);

            tvReservationID.setText("Reservation ID: " + reservation.reservationID);
            tvRestaurantID.setText(reservation.restaurantID);
            tvTableID.setText(reservation.tableID);
            tvReservationDate.setText(reservation.date);
            tvReservationTime.setText(reservation.time);
            tvStatus.setText(reservation.status);
            btnCancel.setTag(reservation.reservationID);
            btnPay.setTag(reservation.reservationID);

            if (reservation.status.equals("Canceled") || reservation.status.equals("FinishedPayment") || reservation.status.equals("Starting") || reservation.status.equals("Finished")) {
                btnCancel.setVisibility(convertView.GONE);
                btnPay.setVisibility(convertView.GONE);
            }

            btnCancel.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    ServerRequests serverRequests = new ServerRequests(v.getContext());
                    serverRequests.cancelReservationByID(v.getTag().toString(), new CancelReservationCallBack() {
                        @Override
                        public void done(boolean isSuccess) {
                            if (isSuccess) {
                                showFinishedMessage();
                            } else {
                                showErrorMessage();
                            }
                        }
                    });
                }
            });

            btnPay.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    Dialog_Payment dialog_payment = new Dialog_Payment();
                    dialog_payment.getData(v.getTag().toString());
                    dialog_payment.show(getSupportFragmentManager(), "Payment");
                }
            });
            return convertView;
        }
    }
    public void closeAllReservation() {
        this.finish();
        Intent intent = new Intent(All_Reservation.this, Account.class);
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
    public void showErrorMessage() {
        Toast.makeText(this, "Sorry, the reservation cancel failed, \n please try again later...", Toast.LENGTH_LONG).show();
        closeAllReservation();
    }
    public void showFinishedMessage() {
        Toast.makeText(this, "The reservation cancel completed!", Toast.LENGTH_LONG).show();
        closeAllReservation();
    }
    public void onClickBooking(View v) {
        this.finish();
        Intent intent = new Intent(All_Reservation.this, Booking.class);
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
        Intent intent = new Intent(All_Reservation.this, Menu.class);
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
        Intent intent = new Intent(All_Reservation.this, Account.class);
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
        Intent intent = new Intent(All_Reservation.this, News.class);
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
    public void onClickNFC(View v) {
        if (nfcAdapter != null && nfcAdapter.isEnabled()) {
            this.finish();
            Intent intent = new Intent(All_Reservation.this, NFC_Home.class);
            intent.putExtra("firstName", customer.firstName);
            intent.putExtra("lastName", customer.lastName);
            intent.putExtra("email", customer.email);
            intent.putExtra("id", customer.accID);
            intent.putExtra("password", customer.password);
            intent.putExtra("phone", customer.phone);
            intent.putExtra("address", customer.address);
            intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
            startActivity(intent);
        } else {
            Toast.makeText(this, "NFC not available, \nplease turn on it.", Toast.LENGTH_LONG).show();
        }
    }
}
