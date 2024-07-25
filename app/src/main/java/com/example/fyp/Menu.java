package com.example.fyp;

import android.content.Intent;
import android.nfc.NfcAdapter;
import android.os.Bundle;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;
import androidx.appcompat.app.AppCompatActivity;
import java.util.ArrayList;

public class Menu extends AppCompatActivity {

    private String firstName, lastName, email, id, phone, address, password;
    private Customer customer;
    private ListView lvFood;
    private ArrayList<Food> foodArrayList = new ArrayList();
    private ArrayList<Food> sushiArrayList = new ArrayList();
    private ArrayList<Food> soupArrayList = new ArrayList();
    private ArrayList<Food> drinkArrayList = new ArrayList();
    private NfcAdapter nfcAdapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.menu);

        firstName = getIntent().getStringExtra("firstName");
        lastName = getIntent().getStringExtra("lastName");
        email = getIntent().getStringExtra("email");
        password = getIntent().getStringExtra("password");
        id = getIntent().getStringExtra("id");
        phone = getIntent().getStringExtra("phone");
        address = getIntent().getStringExtra("address");

        customer = new Customer(id, firstName, lastName, email, password, phone, address);

        lvFood = findViewById(R.id.lvFood);
        nfcAdapter = NfcAdapter.getDefaultAdapter(this);
        getAllFoodFromDB();
    }
    protected void onStart() {
        super.onStart();
        if (email == null && email.length() < 1) {
            Toast.makeText(this, "Sorry, there are error, please login again.", Toast.LENGTH_LONG).show();
            startActivity(new Intent(Menu.this, Login.class));
        }
    }
    public void getAllFoodFromDB() {
        ServerRequests serverRequests = new ServerRequests(this);
        serverRequests.getAllFood(new GetAllFoodCallBack() {
            @Override
            public void done(ArrayList foodArray) {
                if (foodArray != null) {
                    foodArrayList = foodArray;
                    for(int i = 0; i < foodArrayList.size(); i++) {
                        Food data = foodArrayList.get(i);
                        if (data.getCategory().equals("Sushi")) {
                            sushiArrayList.add(data);
                        } else if (data.getCategory().equals("Soup")) {
                            soupArrayList.add(data);
                        } else if (data.getCategory().equals("Drink")) {
                            drinkArrayList.add(data);
                        }
                    }
                } else {
                    Toast.makeText(getApplicationContext(), "Cannot get the menu from server, \n please try again", Toast.LENGTH_LONG).show();
                }
            }
        });
    }
    public class SushiAdapter extends BaseAdapter {

        @Override
        public int getCount() {
            return sushiArrayList.size();
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
            convertView = getLayoutInflater().inflate(R.layout.view_food, null);

            TextView tvFoodName = convertView.findViewById(R.id.tvFoodName);
            TextView tvFoodDescription = convertView.findViewById(R.id.tvFoodDescription);

            Food sushi = sushiArrayList.get(position);

            tvFoodName.setText(sushi.getName());
            tvFoodDescription.setText(sushi.getDescription());

            return convertView;
        }
    }
    public class SoupAdapter extends BaseAdapter {

        @Override
        public int getCount() {
            return soupArrayList.size();
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
            convertView = getLayoutInflater().inflate(R.layout.view_food, null);

            TextView tvFoodName = convertView.findViewById(R.id.tvFoodName);
            TextView tvFoodDescription = convertView.findViewById(R.id.tvFoodDescription);

            Food soup = soupArrayList.get(position);

            tvFoodName.setText(soup.getName());
            tvFoodDescription.setText(soup.getDescription());

            return convertView;
        }
    }
    public class DrinkAdapter extends BaseAdapter {

        @Override
        public int getCount() {
            return drinkArrayList.size();
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
            convertView = getLayoutInflater().inflate(R.layout.view_food, null);

            TextView tvFoodName = convertView.findViewById(R.id.tvFoodName);
            TextView tvFoodDescription = convertView.findViewById(R.id.tvFoodDescription);

            Food drink = drinkArrayList.get(position);

            tvFoodName.setText(drink.getName());
            tvFoodDescription.setText(drink.getDescription());

            return convertView;
        }
    }
    public void onClickDrink(View v) {
        SushiAdapter sushiAdapter = new SushiAdapter();
        lvFood.setAdapter(sushiAdapter);
    }
    public void onClickSoup(View v) {
        SoupAdapter soupAdapter = new SoupAdapter();
        lvFood.setAdapter(soupAdapter);
    }
    public void onClickSushi(View v) {
        DrinkAdapter drinkAdapter = new DrinkAdapter();
        lvFood.setAdapter(drinkAdapter);
    }
    public void onClickNews(View v) {
        this.finish();
        Intent intent = new Intent(Menu.this, News.class);
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
    public void onClickBooking(View v) {
        this.finish();
        Intent intent = new Intent(Menu.this, Booking.class);
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
        Intent intent = new Intent(Menu.this, Account.class);
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
            Intent intent = new Intent(Menu.this, NFC_Home.class);
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
