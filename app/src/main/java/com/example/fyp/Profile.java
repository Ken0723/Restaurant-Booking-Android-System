package com.example.fyp;

import android.content.Intent;
import android.nfc.NfcAdapter;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;
import androidx.appcompat.app.AppCompatActivity;

public class Profile extends AppCompatActivity {

    private Customer customer, nCustomer;
    private String firstName, lastName, email, id, phone, address, password;
    private TextView tvEmail;
    private EditText etFirstName, etLastName, etPhone, etAddress;
    private NfcAdapter nfcAdapter;

    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.profile);

        firstName = getIntent().getStringExtra("firstName");
        lastName = getIntent().getStringExtra("lastName");
        email = getIntent().getStringExtra("email");
        id = getIntent().getStringExtra("id");
        phone = getIntent().getStringExtra("phone");
        address = getIntent().getStringExtra("address");
        password = getIntent().getStringExtra("password");

        customer = new Customer(id, firstName, lastName, email,password, phone, address);
        nfcAdapter = NfcAdapter.getDefaultAdapter(this);

        tvEmail = findViewById(R.id.profile_tvEmail);
        etFirstName = findViewById(R.id.profile_et_FirstName);
        etLastName = findViewById(R.id.profile_etLastName);
        etPhone = findViewById(R.id.profile_etPhoneNum);
        etAddress = findViewById(R.id.profile_etAddress);

        tvEmail.setText(customer.email);
        etFirstName.setText(customer.firstName);
        etLastName.setText(customer.lastName);
        etPhone.setText(customer.phone);
        etAddress.setText(customer.address);
    }
    protected void onStart() {
        super.onStart();
        if (email == null && email.length() < 1) {
            Toast.makeText(this, "Sorry, there are error, please login again.", Toast.LENGTH_LONG).show();
            startActivity(new Intent(Profile.this, Login.class));
        }
    }
    public void onClickSubmit(View v) {
        final String nFirstName, nLastName, nPhone, nAddress;
        nFirstName = etFirstName.getText().toString();
        nLastName = etLastName.getText().toString();
        nPhone = etPhone.getText().toString();
        nAddress = etAddress.getText().toString();

        nCustomer = new Customer(id, nFirstName, nLastName, customer.email, customer.password, nPhone, nAddress);

        ServerRequests serverRequests = new ServerRequests(this);
        serverRequests.updateProfile(nCustomer, new GetUpdateCallBack() {
            @Override
            public void done(boolean isSuccess) {
                if (isSuccess) {
                    closeProfile(nCustomer);
                    Toast.makeText(getApplicationContext(), "Update finished", Toast.LENGTH_LONG).show();
                } else {
                    Toast.makeText(getApplicationContext(), "Update failed", Toast.LENGTH_LONG).show();
                }
            }
        });
    }
    public void onClickCancel(View v) {
        this.finish();
        Intent intent = new Intent(Profile.this, Account.class);
        intent.putExtra("firstName", customer.firstName);
        intent.putExtra("lastName", customer.lastName);
        intent.putExtra("email", customer.email);
        intent.putExtra("id", customer.accID);
        intent.putExtra("phone", customer.phone);
        intent.putExtra("address", customer.address);
        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
        startActivity(intent);
    }
    public void onClickChangePassword(View v) {
        this.finish();
        Intent intent = new Intent(Profile.this, Change_Password.class);
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
    public void closeProfile(Customer customer) {
        this.finish();
        Intent intent = new Intent(Profile.this, Account.class);
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
    public void onClickBooking(View v) {
        this.finish();
        Intent intent = new Intent(Profile.this, Booking.class);
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
        Intent intent = new Intent(Profile.this, Menu.class);
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
    public void onClickNews(View v) {
        this.finish();
        Intent intent = new Intent(Profile.this, News.class);
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
    public void onClickAccount(View v) {
        this.finish();
        Intent intent = new Intent(Profile.this, Account.class);
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
            Intent intent = new Intent(Profile.this, NFC_Home.class);
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