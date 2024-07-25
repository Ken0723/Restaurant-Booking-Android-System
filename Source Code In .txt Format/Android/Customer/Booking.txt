package com.example.fyp;

import android.content.Intent;
import android.nfc.NfcAdapter;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.Toast;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import java.util.ArrayList;

public class Booking extends AppCompatActivity {

    private Customer customer;
    private String firstName, lastName, email, id, phone ,address, password;
    private ArrayList<Table> table = new ArrayList();
    private NfcAdapter nfcAdapter;

    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.booking);

        firstName = getIntent().getStringExtra("firstName");
        lastName = getIntent().getStringExtra("lastName");
        email = getIntent().getStringExtra("email");
        password = getIntent().getStringExtra("password");
        id  = getIntent().getStringExtra("id");
        phone = getIntent().getStringExtra("phone");
        address = getIntent().getStringExtra("address");

        customer = new Customer(id, firstName, lastName, email,password, phone, address);
        nfcAdapter = NfcAdapter.getDefaultAdapter(this);
        getTableStatus();
    }
    protected void onStart() {
        super.onStart();
        if (email == null && email.length() < 1) {
            Toast.makeText(this, "Sorry, there are error, please login again.", Toast.LENGTH_LONG).show();
            startActivity(new Intent(Booking.this, Login.class));
        }
    }
    public void getTableStatus() {
        ServerRequests serverRequests = new ServerRequests(this);
        serverRequests.getTable(new GetTableCallBack() {
            @Override
            public void done(ArrayList tableArray) {
                if (tableArray != null) {
                    table = tableArray;
                    changeTableStatus();
                } else {
                    AlertDialog.Builder dialogBuilder = new AlertDialog.Builder(Booking.this);
                    dialogBuilder.setMessage("Fail to connect to server, please try it again");
                    dialogBuilder.setPositiveButton("OK", null);
                    dialogBuilder.show();
                }
            }
        });
    }
    public void changeTableStatus() {
        int length = table.size();
        for (int i = 0; i < length; i++) {
            if (table.get(i).getStatus().equals("Available") || table.get(i).getStatus().equals("Calling")) {
                String tableNum = "table" + table.get(i).getID();
                int id = getResources().getIdentifier(tableNum, "id", getApplicationContext().getPackageName());
                Button target = findViewById(id);
                target.setBackgroundResource(R.color.available);
            } else if (table.get(i).getStatus().equals("Seated")){
                String tableNum = "table" + table.get(i).getID();
                int id = getResources().getIdentifier(tableNum, "id", getApplicationContext().getPackageName());
                Button target = findViewById(id);
                target.setBackgroundResource(R.color.seated);
            }
        }
    }
    public void onClickTable(View v) {
        Dialog_Table dialog;
        switch(v.getId()) {
            case R.id.table1:
                dialog = new Dialog_Table();
                dialog.getData(table.get(0), customer);
                dialog.show(getSupportFragmentManager(), "Table dialog");
                break;
            case R.id.table2:
                dialog = new Dialog_Table();
                dialog.getData(table.get(1), customer);
                dialog.show(getSupportFragmentManager(), "Table dialog");
                break;
            case R.id.table3:
                dialog = new Dialog_Table();
                dialog.getData(table.get(2), customer);
                dialog.show(getSupportFragmentManager(), "Table dialog");
                break;
            case R.id.table4:
                dialog = new Dialog_Table();
                dialog.getData(table.get(3), customer);
                dialog.show(getSupportFragmentManager(), "Table dialog");
                break;
            case R.id.table5:
                dialog = new Dialog_Table();
                dialog.getData(table.get(4), customer);
                dialog.show(getSupportFragmentManager(), "Table dialog");
                break;
            case R.id.table6:
                dialog = new Dialog_Table();
                dialog.getData(table.get(5), customer);
                dialog.show(getSupportFragmentManager(), "Table dialog");
                break;
            case R.id.table7:
                dialog = new Dialog_Table();
                dialog.getData(table.get(6), customer);
                dialog.show(getSupportFragmentManager(), "Table dialog");
                break;
            case R.id.table8:
                dialog = new Dialog_Table();
                dialog.getData(table.get(7), customer);
                dialog.show(getSupportFragmentManager(), "Table dialog");
                break;
        }
    }
    public void onClickMenu(View v) {
        this.finish();
        Intent intent = new Intent(Booking.this, Menu.class);
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
        Intent intent = new Intent(Booking.this, Account.class);
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
        Intent intent = new Intent(Booking.this, News.class);
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
            Intent intent = new Intent(Booking.this, NFC_Home.class);
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
