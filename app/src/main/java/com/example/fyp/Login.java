package com.example.fyp;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.EditText;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

public class Login extends AppCompatActivity {

    private EditText etEmail;
    private EditText etPassword;

    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.login);

        etEmail = findViewById(R.id.etxtEmail);
        etPassword = findViewById(R.id.etxtPassword);

    }
    public void onLogin(View v) {

        String email = etEmail.getText().toString();
        String password = etPassword.getText().toString();

        Customer customer = new Customer(email, password);

        authenticate(customer);
    }
    public void onClickRegister(View v) {
        startActivity(new Intent(this, Register.class));
    }
    public void authenticate(Customer customer) {
        ServerRequests serverRequests = new ServerRequests(this);
        serverRequests.loginAccountInBackground(getApplication(), customer, new GetUserCallBack() {
            @Override
            public void done(Customer returnedCustomer) {
                if (returnedCustomer == null) {
                    showErrorMessage();
                } else {
                    logIn(returnedCustomer);
                }
            }
        });
    }
    private void showErrorMessage() {
        AlertDialog.Builder dialogBuilder = new AlertDialog.Builder(Login.this);
        dialogBuilder.setMessage("Incorrect email or password, please try again!");
        dialogBuilder.setPositiveButton("OK", null);
        dialogBuilder.show();
    }
    private void logIn(Customer returnedCustomer) {
        this.finish();
        Intent intent = new Intent(Login.this, Account.class);
        intent.putExtra("firstName", returnedCustomer.firstName);
        intent.putExtra("lastName", returnedCustomer.lastName);
        intent.putExtra("email", returnedCustomer.email);
        intent.putExtra("password", returnedCustomer.password);
        intent.putExtra("id", returnedCustomer.accID);
        intent.putExtra("phone", returnedCustomer.phone);
        intent.putExtra("address", returnedCustomer.address);
        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
        startActivity(intent);
    }
}