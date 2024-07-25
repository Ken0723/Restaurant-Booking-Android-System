package com.example.fyp;

import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

public class Register extends AppCompatActivity {

    private EditText etxtFirstName, etxtLastName, etxtEmail, etxtPassword, etxtPhone, etxtAddress;

    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.register);

        etxtFirstName = findViewById(R.id.etxtFirstName);
        etxtLastName = findViewById(R.id.etxtLastNamet);
        etxtEmail = findViewById(R.id.etxtEmail);
        etxtPassword = findViewById(R.id.etxtPassword);
        etxtPhone = findViewById(R.id.etxtPhone);
        etxtAddress = findViewById(R.id.etxtAddress);
    }
    public void onClickSubmit(View v) {
        String firstName = etxtFirstName.getText().toString();
        String lastName = etxtLastName.getText().toString();
        String email = etxtEmail.getText().toString();
        String password = etxtPassword.getText().toString();
        String phone = etxtPhone.getText().toString();
        String address = etxtAddress.getText().toString();

        Customer customer = new Customer();
        customer.setFirstName(firstName);
        customer.setLastName(lastName);
        customer.setEmail(email);
        customer.setPassword(password);
        customer.setPhone(phone);
        customer.setAddress(address);

        registerAccount(customer);
    }
    private void registerAccount(Customer customer) {
        ServerRequests serverRequests = new ServerRequests(this);
        serverRequests.registerUserInBackground(customer, new RegisterCallBack() {
            @Override
            public void done(boolean registerStatus) {
                if (registerStatus) {
                    showMessage(registerStatus);
                } else {
                    showMessage(registerStatus);
                }
            }
        });
    }
    private void showMessage(boolean registerStatus) {
        if (registerStatus) {
            AlertDialog.Builder dialogBuilder = new AlertDialog.Builder(Register.this);
            dialogBuilder.setMessage("Register successful!");
            dialogBuilder.setPositiveButton("OK", new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialog, int which) {
                    Intent intent = new Intent(Register.this, Login.class);
                    intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
                    startActivity(intent);
                }
            });
            dialogBuilder.show();
        } else {
            AlertDialog.Builder dialogBuilder = new AlertDialog.Builder(Register.this);
            dialogBuilder.setMessage("This email already created.\nDo you want to go to login page?");
            dialogBuilder.setNegativeButton("Cancel", null);
            dialogBuilder.setPositiveButton("OK", new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialog, int which) {
                    Intent intent = new Intent(Register.this, Login.class);
                    intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
                    startActivity(intent);
                }
            });
            dialogBuilder.show();
        }
    }
    public void onClickSignIn(View v) {
        Intent intent = new Intent(Register.this, Login.class);
        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
        startActivity(intent);
    }
}
