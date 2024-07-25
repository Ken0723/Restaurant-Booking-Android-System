package com.example.fyp;

import androidx.appcompat.app.AppCompatActivity;
import android.content.Intent;
import android.nfc.NfcAdapter;
import android.os.Bundle;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;
import java.util.ArrayList;

public class News extends AppCompatActivity {

    private ListView lvNews;
    private String firstName, lastName, email, password, id, phone, address;
    private Customer customer;
    private ArrayList<News_Bean> newsArrayList;
    private News_Bean news;
    private NfcAdapter nfcAdapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.news);

        lvNews = findViewById(R.id.lvNews);

        firstName = getIntent().getStringExtra("firstName");
        lastName = getIntent().getStringExtra("lastName");
        email = getIntent().getStringExtra("email");
        password = getIntent().getStringExtra("password");
        id = getIntent().getStringExtra("id");
        phone = getIntent().getStringExtra("phone");
        address = getIntent().getStringExtra("address");

        customer = new Customer(id, firstName, lastName, email, password, phone, address);
        nfcAdapter = NfcAdapter.getDefaultAdapter(this);
        getNewsFromDB();
    }
    protected void onStart() {
        super.onStart();
        if (email == null && email.length() < 1) {
            Toast.makeText(this, "Sorry, there are error, please login again.", Toast.LENGTH_LONG).show();
            startActivity(new Intent(News.this, Login.class));
        }
    }
    public void getNewsFromDB() {
        ServerRequests serverRequests = new ServerRequests(this);
        serverRequests.getAllNews(new GetNewsCallBack() {
            @Override
            public void done(ArrayList newsArray) {
                if (newsArray != null) {
                    newsArrayList = newsArray;
                    setNewsAdapter();
                } else {
                    Toast.makeText(getApplicationContext(), "Cannot get the news from server, \n please try again", Toast.LENGTH_LONG).show();
                }
            }
        });
    }
    public void setNewsAdapter() {
        NewsAdapter newsAdapter = new NewsAdapter();
        lvNews.setAdapter(newsAdapter);
    }
    public class NewsAdapter extends BaseAdapter {

        @Override
        public int getCount() {
            return newsArrayList.size();
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
            convertView = getLayoutInflater().inflate(R.layout.view_news, null);

            TextView tvTitle = convertView.findViewById(R.id.tvTitle);
            TextView tvDescription = convertView.findViewById(R.id.tvDescription);

            news = newsArrayList.get(position);

            tvTitle.setText(news.getTitle());
            tvDescription.setText(news.getDescription());

            return convertView;
        }
    }
    public void onClickBooking(View v) {
        this.finish();
        Intent intent = new Intent(News.this, Booking.class);
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
        Intent intent = new Intent(News.this, Menu.class);
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
        Intent intent = new Intent(News.this, Account.class);
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
            Intent intent = new Intent(News.this, NFC_Home.class);
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
