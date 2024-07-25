package com.example.fyp;

import android.content.Intent;
import android.nfc.NfcAdapter;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;
import androidx.appcompat.app.AppCompatActivity;

public class Change_Password extends AppCompatActivity {

    private Customer customer;
    private String firstName, lastName, email, id, phone, address, password;
    private EditText etOldPassword, etNewPassword, etConfirmPassword;
    private NfcAdapter nfcAdapter;

    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.change_password);

        firstName = getIntent().getStringExtra("firstName");
        lastName = getIntent().getStringExtra("lastName");
        email = getIntent().getStringExtra("email");
        id = getIntent().getStringExtra("id");
        phone = getIntent().getStringExtra("phone");
        address = getIntent().getStringExtra("address");
        password = getIntent().getStringExtra("password");

        customer = new Customer(id, firstName, lastName, email, password, phone, address);
        nfcAdapter = NfcAdapter.getDefaultAdapter(this);
        etOldPassword = findViewById(R.id.et_OldPassword);
        etNewPassword = findViewById(R.id.et_NewPassword);
        etConfirmPassword = findViewById(R.id.et_ConfirmPassword);
    }
    protected void onStart() {
        super.onStart();
        if (email == null && email.length() < 1) {
            Toast.makeText(this, "Sorry, there are error, please login again.", Toast.LENGTH_LONG).show();
            startActivity(new Intent(Change_Password.this, Login.class));
        }
    }
    public void onClickPasswordSubmit(View v) {
        String nOldPassword, nNewPassword, nConfirmPassword;

        nOldPassword = etOldPassword.getText().toString();
        nNewPassword = etNewPassword.getText().toString();
        nConfirmPassword = etConfirmPassword.getText().toString();

        if (nOldPassword.equals(customer.getPassword()) && !(nOldPassword == null || nOldPassword.equals(""))) {
            if (nNewPassword.equals(nConfirmPassword)&& !(nOldPassword == null || nOldPassword.equals("")) && !(nConfirmPassword == null || nConfirmPassword.equals(""))) {
                ServerRequests serverRequests = new ServerRequests(this);
                serverRequests.updatePassword(customer, nNewPassword, new GetUpdateCallBack() {
                    @Override
                    public void done(boolean isSuccess) {
                        if (isSuccess) {
                            Toast.makeText(getApplicationContext(), "Update completed,\n please login again", Toast.LENGTH_LONG).show();
                            closeChangePassword();
                        } else {
                            Toast.makeText(getApplicationContext(), "Please check the password", Toast.LENGTH_LONG).show();
                        }
                    }
                });
            } else {
                Toast.makeText(getApplicationContext(), "The password and confirm password must be the same!", Toast.LENGTH_LONG).show();
            }
        } else {
            Toast.makeText(getApplicationContext(), "Please enter the correct old password!", Toast.LENGTH_LONG).show();
        }
    }
    public void onClickPasswordCancel(View v) {
        this.finish();
        Intent intent = new Intent(Change_Password.this, Profile.class);
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
    public void closeChangePassword() {
        this.finish();
        Intent intent = new Intent(Change_Password.this, Login.class);
        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
        startActivity(intent);
    }
    public void onClickBooking(View v) {
        this.finish();
        Intent intent = new Intent(Change_Password.this, Booking.class);
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
        Intent intent = new Intent(Change_Password.this, Menu.class);
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
        Intent intent = new Intent(Change_Password.this, Account.class);
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
        Intent intent = new Intent(Change_Password.this, News.class);
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
            Intent intent = new Intent(Change_Password.this, NFC_Home.class);
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
