package com.example.fyp;

import android.content.Intent;
import android.net.Uri;
import android.nfc.NfcAdapter;
import android.os.Bundle;
import android.view.View;
import android.widget.TextView;
import android.widget.Toast;
import androidx.appcompat.app.AppCompatActivity;


public class Account extends AppCompatActivity {

    private TextView displayCustomer;
    private String firstName, lastName, email, id, phone, address, password;
    private Customer customer;
    private NfcAdapter nfcAdapter;

    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.account);

        firstName = getIntent().getStringExtra("firstName");
        lastName = getIntent().getStringExtra("lastName");
        email = getIntent().getStringExtra("email");
        password = getIntent().getStringExtra("password");
        id = getIntent().getStringExtra("id");
        phone = getIntent().getStringExtra("phone");
        address = getIntent().getStringExtra("address");

        displayCustomer = findViewById(R.id.txtViewCustomer);

        customer = new Customer(id, firstName, lastName, email, password, phone, address);
        nfcAdapter = NfcAdapter.getDefaultAdapter(this);
    }
    protected void onStart() {
        super.onStart();
        if (email != null && email != "") {
            displayCustomer();
        } else {
            Toast.makeText(this, "Sorry, there are error, please login again.", Toast.LENGTH_LONG).show();
            startActivity(new Intent(Account.this, Login.class));
        }
    }
    private void displayCustomer() {
        displayCustomer.setText("Welcome back, \n" + customer.getFirstName() + " " + customer.getLastName());
    }
    public void onClickBooking(View v) {
        this.finish();
        Intent intent = new Intent(Account.this, Booking.class);
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
        Intent intent = new Intent(Account.this, Menu.class);
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
    public void onClickProfile(View v) {
        this.finish();
        Intent intent = new Intent(Account.this, Profile.class);
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
            Intent intent = new Intent(Account.this, News.class);
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
    public void onClickAllReservation(View v) {
        this.finish();
        Intent intent = new Intent(Account.this, All_Reservation.class);
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
    public void onClickMap(View v) {
        ServerRequests serverRequests = new ServerRequests(this);
        serverRequests.getLocation(new GetRestaurantLocationCallBack() {
            @Override
            public void done(Location gotLocation) {
                if (gotLocation != null) {
                    Intent intent = new Intent(Intent.ACTION_VIEW, Uri.parse("geo:" + gotLocation.getX() + "," + gotLocation.getY() + "?z=17&q=+" + gotLocation.getX() + "," + gotLocation.getY() + "(Label + Restaurant)"));
                    startActivity(intent);
                    Account.this.finish();
                } else {
                    Toast.makeText(Account.this, "Getting location failed, please try again", Toast.LENGTH_SHORT).show();
                }
            }
        });
    }
    public void onClickNFC(View v) {
        if (nfcAdapter != null && nfcAdapter.isEnabled()) {
            this.finish();
            Intent intent = new Intent(Account.this, NFC_Home.class);
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
