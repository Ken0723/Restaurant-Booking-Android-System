package com.example.fyp;


import android.app.ProgressDialog;
import android.content.Context;
import android.nfc.NfcAdapter;
import android.os.AsyncTask;
import android.telecom.Call;
import android.util.Log;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;
import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;

public class ServerRequests {

    ProgressDialog progressDialog;

    public static final String SERVER_ADDRESS = "http://52.90.32.203/FYP/";
    public static final int TIMEOUT_CONNECTION = 5000;

    public ServerRequests(Context context) {
        progressDialog = new ProgressDialog(context);
        progressDialog.setCancelable(false);
        progressDialog.setTitle("Processing");
        progressDialog.setMessage("Please wait...");
    }
    public void loginAccountInBackground(Context context, Customer customer, GetUserCallBack callBack) {
        progressDialog.show();
        new loginAsyncTask(context, customer, callBack).execute();
    }
    public void registerUserInBackground(Customer customer, RegisterCallBack callBack) {
        progressDialog.show();
        new registerAsyncTask(customer, callBack).execute();
    }
    public void getTable(GetTableCallBack callBack) {
        progressDialog.show();
        new getTableAsyncTask(callBack).execute();
    }
    public void getReservation (Table tableData, String date, GetReservationCallBack callBack) {
        progressDialog.show();
        new getTableBookingAsyncTask(tableData, date, callBack).execute();
    }
    public void bookingSeat(Customer customer, Table table, String time, String date, GetBookingCallBack callBack) {
        progressDialog.show();
        new bookingSeatAsyncTask(customer, table, time, date, callBack).execute();
    }
    public void updateProfile(Customer customer, GetUpdateCallBack callBack) {
        progressDialog.show();
        new updateProfileAsyncTask(customer, callBack).execute();
    }
    public void updatePassword(Customer customer, String newPassword, GetUpdateCallBack callBack) {
        progressDialog.show();
        new updatePasswordAsyncTask(customer, newPassword, callBack).execute();
    }
    public void getAllReservationByID(Customer customer, GetReservationCallBack callBack) {
        progressDialog.show();
        new getAllReservationByIDAsyncTask(customer, callBack).execute();
    }
    public void cancelReservationByID(String id, CancelReservationCallBack callBack) {
        progressDialog.show();
        new cancelReservationByIDAsyncTask(id, callBack).execute();
    }
    public void getAllNews(GetNewsCallBack callBack) {
        progressDialog.show();
        new getAllNewsAsyncTask(callBack).execute();
    }
    public void getAllFood(GetAllFoodCallBack callBack) {
        progressDialog.show();
        new getAllFoodAsyncTask(callBack).execute();
    }
    public void NfcChecking(Customer customer, String tableId, GetOwnReservationCallBack callBack) {
        progressDialog.show();
        new NfcCheckingAsyncTask(customer, tableId, callBack).execute();
    }
    public void isStartingReservation(Customer customer, GetStartingReservationCallBack callBack) {
        progressDialog.show();
        new isStartingReservationAsyncTask(customer, callBack).execute();
    }
    public void startReservation (Reservation reservation, StartReservationCallBack callBack) {
        progressDialog.show();
        new startReservationAsyncTask(reservation, callBack).execute();
    }
    public void orderFood(Order order, OrderFoodCallBack callBack) {
        progressDialog.show();
        new orderFoodAsyncTask(order, callBack).execute();
    }
    public void callWaiter(Reservation reservation, CallWaiterCallBack callBack) {
        progressDialog.show();
        new callWaiterAsyncTask(reservation, callBack).execute();
    }
    public void getAllOrderID(Reservation reservation, GetAllOrderIDCallBack callBack) {
        progressDialog.show();
        new getAllOrderIDAsyncTask(reservation, callBack).execute();
    }
    public void getOrderFood(GetOrderedFoodCallBack callBack) {
        progressDialog.show();
        new getOrderFoodAsyncTask(callBack).execute();
    }
    public void getLocation(GetRestaurantLocationCallBack callBack) {
        progressDialog.show();
        new getLocationAsyncTask(callBack).execute();
    }
    public void payment(String reservationId, String cardNum, String securityCode, String date, PaymentCallBack callBack) {
        progressDialog.show();
        new payment(reservationId, cardNum, securityCode, date, callBack).execute();
    }

    public class loginAsyncTask extends AsyncTask<Void, Void, Customer> {

        Customer customer;
        GetUserCallBack userCallBack;
        private Context mContext;

        public loginAsyncTask(Context context, Customer customer, GetUserCallBack callBack) {
            this.mContext = context;
            this.customer = customer;
            this.userCallBack = callBack;
        }

        @Override
        protected Customer doInBackground(Void... params) {

            Customer returnedCustomer = null;

            try {
                URL url = new URL(SERVER_ADDRESS + "Login.php");
                HttpURLConnection connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("POST");
                connection.setConnectTimeout(TIMEOUT_CONNECTION);
                connection.setReadTimeout(TIMEOUT_CONNECTION);
                connection.setDoInput(true);
                connection.setDoOutput(true);

                OutputStream ops = connection.getOutputStream();
                BufferedWriter writer = new BufferedWriter(new OutputStreamWriter(ops));

                String data = "email=" + customer.email + "&&" + "password=" + customer.password;

                writer.write(data);
                writer.flush();
                writer.close();
                ops.close();

                InputStream ips = connection.getInputStream();
                BufferedReader reader = new BufferedReader(new InputStreamReader(ips));

                StringBuffer buffer = new StringBuffer();
                String line = "";

                while ((line = reader.readLine()) != null) {
                    buffer.append(line + "\n");
                }
                String result = buffer.toString();
                JSONObject json = new JSONObject(result);
                if (json != null && json.length() > 0) {
                    returnedCustomer = new Customer(customer.email, customer.password);
                    returnedCustomer.setAccID(json.getString("ID"));
                }
                reader.close();
                ips.close();
                connection.disconnect();

                if (json != null && json.length() > 0) {
                    url = new URL(SERVER_ADDRESS + "SelectCustomer.php");
                    connection = (HttpURLConnection) url.openConnection();
                    connection.setRequestMethod("POST");
                    connection.setDoInput(true);
                    connection.setDoOutput(true);
                    connection.setConnectTimeout(TIMEOUT_CONNECTION);

                    ops = connection.getOutputStream();
                    writer = new BufferedWriter(new OutputStreamWriter(ops));

                    data = "userID=" + returnedCustomer.accID;

                    writer.write(data);
                    writer.flush();
                    writer.close();
                    ops.close();

                    ips = connection.getInputStream();
                    reader = new BufferedReader(new InputStreamReader(ips));

                    buffer = new StringBuffer();
                    line = "";
                    while ((line = reader.readLine()) != null) {
                        buffer.append(line + "\n");
                    }
                    result = buffer.toString();
                    json = new JSONObject(result);
                    returnedCustomer.setFirstName(json.getString("FirstName"));
                    returnedCustomer.setLastName(json.getString("LastName"));
                    returnedCustomer.setPhone(json.getString("Phone"));
                    returnedCustomer.setAddress(json.getString("Address"));
                    reader.close();
                    ips.close();
                } else {
                    returnedCustomer = null;
                }
                connection.disconnect();
            } catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (java.net.SocketTimeoutException e) {
                this.cancel(true);
            } catch(IllegalArgumentException e) {
                this.cancel(true);
            }   catch (IOException e) {
                e.printStackTrace();
            } catch (JSONException e) {
                e.printStackTrace();
            }
            return returnedCustomer;
        }
        protected void onPostExecute(Customer returnedCustomer) {
            super.onPostExecute(returnedCustomer);
            if (!isCancelled()) {
                progressDialog.dismiss();
                userCallBack.done(returnedCustomer);
            } else {
                Toast.makeText(mContext, "Connect to server time out!", Toast.LENGTH_SHORT).show();
                progressDialog.dismiss();
            }
        }
    }

    public class registerAsyncTask extends AsyncTask<Void, Void, Boolean> {

        Customer customer;
        RegisterCallBack registerCallBack;
        boolean isFinished = true;

        public registerAsyncTask(Customer customer, RegisterCallBack callBack) {
            this.customer = customer;
            this.registerCallBack = callBack;
        }

        @Override
        protected Boolean doInBackground(Void... params) {
            try {
                URL url = new URL(SERVER_ADDRESS + "CheckAccount.php");
                HttpURLConnection connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("POST");
                connection.setDoInput(true);
                connection.setDoOutput(true);

                OutputStream ops = connection.getOutputStream();
                BufferedWriter writer = new BufferedWriter(new OutputStreamWriter(ops));

                String data = "email=" + customer.email;
                writer.write(data);
                writer.flush();
                writer.close();
                ops.close();

                InputStream ips = connection.getInputStream();
                BufferedReader reader = new BufferedReader(new InputStreamReader(ips));
                StringBuffer buffer = new StringBuffer();
                String line = "";

                while ((line = reader.readLine()) != null) {
                    buffer.append(line + "\n");
                }
                String result = buffer.toString();
                if (result == null || result.equals("")) {
                    url = new URL(SERVER_ADDRESS + "Register.php");
                    connection = (HttpURLConnection) url.openConnection();
                    connection.setRequestMethod("POST");
                    connection.setDoInput(true);
                    connection.setDoOutput(true);

                    ops = connection.getOutputStream();
                    writer = new BufferedWriter(new OutputStreamWriter(ops));

                    data = "firstName=" + customer.firstName + "&&lastName=" + customer.lastName + "&&email=" + customer.email + "&&password=" + customer.password + "&&phone=" + customer.phone + "&&address=" + customer.address;
                    writer.write(data);
                    writer.flush();
                    writer.close();
                    ops.close();

                    ips = connection.getInputStream();
                    reader = new BufferedReader(new InputStreamReader(ips));
                    buffer = new StringBuffer();
                    line = "";

                    while ((line = reader.readLine()) != null) {
                        buffer.append(line + "\n");
                    }
                    result = buffer.toString();
                    if (result != null && result.length() > 0) {
                        isFinished = true;
                    } else {
                        isFinished = false;
                    }
                    reader.close();
                    ips.close();
                    connection.disconnect();
                } else {
                    isFinished = false;
                }

            } catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }

            return isFinished;
        }
        protected void onPostExecute(Boolean registerStatus) {
            super.onPostExecute(registerStatus);
            progressDialog.dismiss();
            registerCallBack.done(registerStatus);
        }

    }

    public class getTableAsyncTask extends AsyncTask<Void, Void, ArrayList> {

        GetTableCallBack getTableCallBack;
        ArrayList<Table> tableArray = new ArrayList<Table>();

        public getTableAsyncTask(GetTableCallBack getTableCallBack) {
            this.getTableCallBack = getTableCallBack;
        }

        @Override
        protected ArrayList doInBackground(Void... voids) {
            try {
                URL url = new URL(SERVER_ADDRESS + "SelectTable.php");
                HttpURLConnection connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("POST");
                connection.setDoInput(true);
                connection.setDoOutput(true);


                InputStream ips = connection.getInputStream();
                BufferedReader reader = new BufferedReader(new InputStreamReader(ips));
                StringBuffer buffer = new StringBuffer();
                String line = "";

                while ((line = reader.readLine()) != null) {
                    buffer.append(line + "\n");
                }
                String result = buffer.toString();
                if (result != null && result.length() > 0) {
                    JSONArray jsonArray = new JSONArray(result);
                    Table table;
                    for (int i = 0; i < jsonArray.length(); i++) {
                        JSONObject data = jsonArray.getJSONObject(i);
                        table = new Table(Integer.parseInt(data.getString("ID")), Integer.parseInt(data.getString("TableNum")), Integer.parseInt(data.getString("TableSize")), data.getString("Status"));
                        tableArray.add(table);
                    }
                } else {
                    tableArray = null;
                }
                connection.disconnect();
            } catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }  catch (JSONException e) {
                e.printStackTrace();
            }
            return tableArray;
        }
        protected void onPostExecute(ArrayList tableArray) {
            super.onPostExecute(tableArray);
            progressDialog.dismiss();
            getTableCallBack.done(tableArray);
        }
    }

    public class getTableBookingAsyncTask extends AsyncTask<Void, Void, ArrayList> {

        private Table table;
        private ArrayList<Reservation> reservationsArray = new ArrayList<Reservation>();
        private GetReservationCallBack bookingCallBack;
        private String date;

        public getTableBookingAsyncTask(Table tableData, String date, GetReservationCallBack callBack) {
            this.table = tableData;
            this.bookingCallBack = callBack;
            this.date = date;
        }

        @Override
        protected ArrayList doInBackground(Void... voids) {
            try {
                URL url = new URL(SERVER_ADDRESS + "GetReservation.php");
                HttpURLConnection connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("POST");
                connection.setDoInput(true);
                connection.setDoOutput(true);

                OutputStream ops = connection.getOutputStream();
                BufferedWriter writer = new BufferedWriter(new OutputStreamWriter(ops));

                String data = "restaurantID=1" +  "&tableID=" + table.getID() + "&date=" + date;
                writer.write(data);
                writer.flush();
                writer.close();
                ops.close();

                InputStream ips = connection.getInputStream();
                BufferedReader reader = new BufferedReader(new InputStreamReader(ips));
                StringBuffer buffer = new StringBuffer();
                String line = "";

                while ((line = reader.readLine()) != null) {
                    buffer.append(line + "\n");
                }
                String result = buffer.toString();
                if (result != null && result.length() > 0) {
                    JSONArray jsonArray = new JSONArray(result);
                    for (int i = 0; i < jsonArray.length(); i++) {
                        JSONObject reservationData = jsonArray.getJSONObject(i);
                        reservationsArray.add(new Reservation(
                                reservationData.getString("ReservationID"),
                                reservationData.getString("RestaurantID"),
                                reservationData.getString("CustomerID"),
                                reservationData.getString("TableID"),
                                reservationData.getString("ReservationDate"),
                                reservationData.getString("ReservationsTime"),
                                reservationData.getString("Status")));
                    }

                } else {
                    reservationsArray = null;
                }
                connection.disconnect();
            } catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }  catch (JSONException e) {
                return reservationsArray = null;
            }
            return reservationsArray;
        }
        protected void onPostExecute(ArrayList reservationsArray) {
            super.onPostExecute(reservationsArray);
            progressDialog.dismiss();
            bookingCallBack.done(reservationsArray);
        }
    }

    public class bookingSeatAsyncTask extends AsyncTask<Void, Void, Boolean> {

        private Customer customer;
        private Table table;
        private String time, date;
        private GetBookingCallBack callBack;
        private boolean isSuccess = true;

        public bookingSeatAsyncTask(Customer customer, Table table, String time, String date, GetBookingCallBack callBack) {
            this.customer = customer;
            this.table = table;
            this.time = time;
            this.date = date;
            this.callBack = callBack;
        }
        @Override
        protected Boolean doInBackground(Void... voids) {
            try {
                URL url = new URL(SERVER_ADDRESS + "CheckReservation.php");
                HttpURLConnection connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("POST");
                connection.setDoInput(true);
                connection.setDoOutput(true);
                OutputStream ops = connection.getOutputStream();
                BufferedWriter writer = new BufferedWriter(new OutputStreamWriter(ops));

                String data = "restaurantID=1" + "&tableID=" + table.getID() + "&date=" + date + "&time=" + time;
                writer.write(data);
                writer.flush();
                writer.close();
                ops.close();

                InputStream ips = connection.getInputStream();
                BufferedReader reader = new BufferedReader(new InputStreamReader(ips));
                StringBuffer buffer = new StringBuffer();
                String line = "";

                while ((line = reader.readLine()) != null) {
                    buffer.append(line + "\n");
                }
                String result = buffer.toString();
                if (result != null  && result.length() > 0) {
                    url = new URL(SERVER_ADDRESS + "BookingSeat.php");
                    connection = (HttpURLConnection) url.openConnection();
                    connection.setRequestMethod("POST");
                    connection.setDoInput(true);
                    connection.setDoOutput(true);
                    ops = connection.getOutputStream();
                    writer = new BufferedWriter(new OutputStreamWriter(ops));

                    data = "restaurantID=1" + "&customerID=" + customer.getAccID() + "&tableID=" + table.getID() + "&date=" + date + "&time=" + time;
                    writer.write(data);
                    writer.flush();
                    writer.close();
                    ops.close();

                    ips = connection.getInputStream();
                    reader = new BufferedReader(new InputStreamReader(ips));
                    buffer = new StringBuffer();
                    line = "";

                    while ((line = reader.readLine()) != null) {
                        buffer.append(line + "\n");
                    }
                    result = buffer.toString();
                    connection.disconnect();
                } else {
                    isSuccess = false;
                }
            }  catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }
            return isSuccess;
        }
        protected void onPostExecute(Boolean isSuccess) {
            super.onPostExecute(isSuccess);
            progressDialog.dismiss();
            callBack.done(isSuccess);
        }
    }

    public class updateProfileAsyncTask extends AsyncTask<Void, Void, Boolean> {

        private Customer customer;
        private boolean isSuccess = true;
        private GetUpdateCallBack callBack;

        public updateProfileAsyncTask(Customer customer, GetUpdateCallBack callBack) {
            this.customer = customer;
            this.callBack = callBack;
        }
        @Override
        protected Boolean doInBackground(Void... voids) {
            try {
                URL url = new URL(SERVER_ADDRESS + "UpdateProfile.php");
                HttpURLConnection connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("POST");
                connection.setDoInput(true);
                connection.setDoOutput(true);
                OutputStream ops = connection.getOutputStream();
                BufferedWriter writer = new BufferedWriter(new OutputStreamWriter(ops));

                String data = "customerID=" + customer.getAccID() + "&lastName=" + customer.getLastName() + "&firstName=" + customer.getFirstName()
                        + "&phone=" + customer.getPhone() + "&address=" + customer.getAddress();
                writer.write(data);
                writer.flush();
                writer.close();
                ops.close();

                InputStream ips = connection.getInputStream();
                BufferedReader reader = new BufferedReader(new InputStreamReader(ips));
                StringBuffer buffer = new StringBuffer();
                String line = "";

                while ((line = reader.readLine()) != null) {
                    buffer.append(line + "\n");
                }
                String result = buffer.toString();
                if (result == null  && result.length() < 1) {
                    isSuccess = false;
                }
                connection.disconnect();
            }  catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }
            return isSuccess;
        }
        protected void onPostExecute(Boolean isSuccess) {
            super.onPostExecute(isSuccess);
            progressDialog.dismiss();
            callBack.done(isSuccess);
        }
    }

    public class updatePasswordAsyncTask extends AsyncTask<Void, Void, Boolean> {

        private Customer customer;
        private String newPassword;
        private GetUpdateCallBack callBack;
        private boolean isSuccess = true;

        public updatePasswordAsyncTask(Customer customer, String newPassword, GetUpdateCallBack callBack) {
            this.customer = customer;
            this.newPassword = newPassword;
            this.callBack = callBack;
        }
        @Override
        protected Boolean doInBackground(Void... voids) {
            try {
                URL url = new URL(SERVER_ADDRESS + "UpdatePassword.php");
                HttpURLConnection connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("POST");
                connection.setDoInput(true);
                connection.setDoOutput(true);
                OutputStream ops = connection.getOutputStream();
                BufferedWriter writer = new BufferedWriter(new OutputStreamWriter(ops));

                String data = "customerID=" + customer.getAccID() + "&password=" + newPassword;
                writer.write(data);
                writer.flush();
                writer.close();
                ops.close();

                InputStream ips = connection.getInputStream();
                BufferedReader reader = new BufferedReader(new InputStreamReader(ips));
                StringBuffer buffer = new StringBuffer();
                String line = "";

                while ((line = reader.readLine()) != null) {
                    buffer.append(line + "\n");
                }
                String result = buffer.toString();

                if (result == null && result.length() < 1) {
                    isSuccess = false;
                }
                connection.disconnect();
            }  catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }
            return isSuccess;
        }

        @Override
        protected void onPostExecute(Boolean isSuccess) {
            super.onPostExecute(isSuccess);
            progressDialog.dismiss();
            callBack.done(isSuccess);
        }
    }

    public class getAllReservationByIDAsyncTask extends AsyncTask<Void, Void, ArrayList> {

        private Customer customer;
        private GetReservationCallBack callBack;
        private ArrayList<Reservation> reservationArrayList = new ArrayList<Reservation>();

        public getAllReservationByIDAsyncTask(Customer customer, GetReservationCallBack callBack) {
            this.customer = customer;
            this.callBack = callBack;
        }
        @Override
        protected ArrayList doInBackground(Void... voids) {
            try {
                URL url = new URL(SERVER_ADDRESS + "GetReservationByID.php");
                HttpURLConnection connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("POST");
                connection.setDoInput(true);
                connection.setDoOutput(true);
                OutputStream ops = connection.getOutputStream();
                BufferedWriter writer = new BufferedWriter(new OutputStreamWriter(ops));

                String data = "customerID=" + customer.getAccID();
                writer.write(data);
                writer.flush();
                writer.close();
                ops.close();

                InputStream ips = connection.getInputStream();
                BufferedReader reader = new BufferedReader(new InputStreamReader(ips));
                StringBuffer buffer = new StringBuffer();
                String line = "";
                while ((line = reader.readLine()) != null) {
                    buffer.append(line + "\n");
                }
                String result = buffer.toString();
                if (result == null && result.length() < 1) {
                    reservationArrayList = null;
                } else {
                    JSONArray jsonArray = new JSONArray(result);
                    for(int i = 0; i < jsonArray.length(); i++) {
                        JSONObject reservationData = jsonArray.getJSONObject(i);
                        reservationArrayList.add(new Reservation(
                                reservationData.getString("ReservationID"),
                                reservationData.getString("RestaurantID"),
                                reservationData.getString("CustomerID"),
                                reservationData.getString("TableID"),
                                reservationData.getString("ReservationDate"),
                                reservationData.getString("ReservationsTime"),
                                reservationData.getString("Status")));
                    }
                }
                connection.disconnect();
            } catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            } catch (JSONException e) {
                e.printStackTrace();
            }
            return reservationArrayList;
        }

        @Override
        protected void onPostExecute(ArrayList arrayList) {
            super.onPostExecute(arrayList);
            progressDialog.dismiss();
            callBack.done(arrayList);
        }
    }

    public class cancelReservationByIDAsyncTask extends AsyncTask<Void, Void, Boolean> {

        private boolean isSuccess = true;
        private String id;
        private CancelReservationCallBack callBack;

        public cancelReservationByIDAsyncTask(String id, CancelReservationCallBack callBack) {
            this.id = id;
            this.callBack = callBack;
        }
        @Override
        protected Boolean doInBackground(Void... voids) {
            try {
                URL url = new URL(SERVER_ADDRESS + "CancelReservationByID.php");
                HttpURLConnection connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("POST");
                connection.setDoInput(true);
                connection.setDoOutput(true);
                OutputStream ops = connection.getOutputStream();
                BufferedWriter writer = new BufferedWriter(new OutputStreamWriter(ops));

                String data = "reservationID=" + id;
                writer.write(data);
                writer.flush();
                writer.close();
                ops.close();

                InputStream ips = connection.getInputStream();
                BufferedReader reader = new BufferedReader(new InputStreamReader(ips));
                StringBuffer buffer = new StringBuffer();
                String line = "";
                while ((line = reader.readLine()) != null) {
                    buffer.append(line + "\n");
                }
                String result = buffer.toString();
                if (result == null && result.length() < 1) {
                    isSuccess = false;
                }
                connection.disconnect();
            } catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }
            return isSuccess;
        }

        @Override
        protected void onPostExecute(Boolean isSuccess) {
            super.onPostExecute(isSuccess);
            progressDialog.dismiss();
            callBack.done(isSuccess);
        }
    }

    public class getAllNewsAsyncTask extends AsyncTask<Void, Void, ArrayList> {

        private ArrayList<News_Bean> newsArrayList = new ArrayList<News_Bean>();
        private GetNewsCallBack callBack;

        public getAllNewsAsyncTask(GetNewsCallBack callBack) {
            this.callBack = callBack;
        }

        @Override
        protected ArrayList doInBackground(Void... voids) {
            try {
                URL url = new URL(SERVER_ADDRESS + "GetAllNews.php");
                HttpURLConnection connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("POST");
                connection.setDoInput(true);
                connection.setDoOutput(true);


                InputStream ips = connection.getInputStream();
                BufferedReader reader = new BufferedReader(new InputStreamReader(ips));
                StringBuffer buffer = new StringBuffer();
                String line = "";
                while ((line = reader.readLine()) != null) {
                    buffer.append(line + "\n");
                }
                String result = buffer.toString();
                if (result == null && result.length() < 1) {
                    newsArrayList = null;
                } else {
                    JSONArray jsonArray = new JSONArray(result);
                    for(int i = 0; i < jsonArray.length(); i++) {
                        JSONObject newsData = jsonArray.getJSONObject(i);
                        newsArrayList.add(new News_Bean(
                                newsData.getString("ID"),
                                newsData.getString("Title"),
                                newsData.getString("Description")));
                    }
                }
                connection.disconnect();
            } catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            } catch (JSONException e) {
                e.printStackTrace();
            }
            return newsArrayList;
        }
        protected void onPostExecute(ArrayList newsArrayList) {
            super.onPostExecute(newsArrayList);
            progressDialog.dismiss();
            callBack.done(newsArrayList);
        }
    }

    public class getAllFoodAsyncTask extends AsyncTask<Void, Void, ArrayList> {

        private ArrayList<Food> foodArrayList = new ArrayList<>();
        private GetAllFoodCallBack callBack;

        public getAllFoodAsyncTask(GetAllFoodCallBack callBack) {
            this.callBack = callBack;
        }
        @Override
        protected ArrayList doInBackground(Void... voids) {
            try {
                URL url = new URL(SERVER_ADDRESS + "GetAllFood.php");
                HttpURLConnection connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("POST");
                connection.setDoInput(true);
                connection.setDoOutput(true);

                InputStream ips = connection.getInputStream();
                BufferedReader reader = new BufferedReader(new InputStreamReader(ips));
                StringBuffer buffer = new StringBuffer();
                String line = "";
                while ((line = reader.readLine()) != null) {
                    buffer.append(line + "\n");
                }
                String result = buffer.toString();
                if (result == null && result.length() < 1) {
                    foodArrayList = null;
                } else {
                    JSONArray jsonArray = new JSONArray(result);
                    for(int i = 0; i < jsonArray.length(); i++) {
                        JSONObject foodData = jsonArray.getJSONObject(i);
                        foodArrayList.add(new Food(
                                foodData.getString("Code"),
                                foodData.getString("Name"),
                                foodData.getString("FoodCategory"),
                                Double.parseDouble(foodData.getString("PriceEach")),
                                foodData.getString("Description")));
                    }
                }
                connection.disconnect();
            } catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            } catch (JSONException e) {
                e.printStackTrace();
            }
            return foodArrayList;
        }
        protected void onPostExecute(ArrayList foodArrayList) {
            super.onPostExecute(foodArrayList);
            progressDialog.dismiss();
            callBack.done(foodArrayList);
        }
    }

    public class NfcCheckingAsyncTask extends AsyncTask<Void, Void, Reservation> {

        private Reservation reservation;
        private Customer customer;
        private String id;
        private GetOwnReservationCallBack callBack;

        public NfcCheckingAsyncTask(Customer customer, String id, GetOwnReservationCallBack callBack) {
            this.customer = customer;
            this.id = id;
            this.callBack = callBack;
        }
        @Override
        protected Reservation doInBackground(Void... voids) {
            try {
                URL url = new URL(SERVER_ADDRESS + "GetOwnReservation.php");
                HttpURLConnection connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("POST");
                connection.setDoInput(true);
                connection.setDoOutput(true);
                OutputStream ops = connection.getOutputStream();
                BufferedWriter writer = new BufferedWriter(new OutputStreamWriter(ops));

                String data = "customerID=" + customer.getAccID() + "&tableID=" + id;
                writer.write(data);
                writer.flush();
                writer.close();
                ops.close();

                InputStream ips = connection.getInputStream();
                BufferedReader reader = new BufferedReader(new InputStreamReader(ips));
                StringBuffer buffer = new StringBuffer();
                String line = "";
                while ((line = reader.readLine()) != null) {
                    buffer.append(line + "\n");
                }
                String result = buffer.toString();
                if (result != null && result.length() > 0) {
                    JSONObject jsonObject = new JSONObject(result);
                        reservation =
                                new Reservation(
                                        jsonObject.getString("ReservationID"),
                                        jsonObject.getString("RestaurantID"),
                                        jsonObject.getString("CustomerID"),
                                        jsonObject.getString("TableID"),
                                        jsonObject.getString("ReservationDate"),
                                        jsonObject.getString("ReservationsTime"),
                                        jsonObject.getString("Status")
                                );
                } else {
                    reservation = null;
                }
                connection.disconnect();
            } catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            } catch (JSONException e) {
                e.printStackTrace();
            }
            return reservation;
        }
        protected void onPostExecute(Reservation reservation) {
            super.onPostExecute(reservation);
            progressDialog.dismiss();
            callBack.done(reservation);
        }
    }

    public class isStartingReservationAsyncTask extends AsyncTask<Void, Void, Reservation> {

        private Reservation reservation;
        private Customer customer;
        private GetStartingReservationCallBack callBack;

        public isStartingReservationAsyncTask(Customer customer, GetStartingReservationCallBack callBack) {
            this.customer = customer;
            this.callBack = callBack;
        }

        @Override
        protected Reservation doInBackground(Void... voids) {
            try {
                URL url = new URL(SERVER_ADDRESS + "GetStartingReservation.php");
                HttpURLConnection connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("POST");
                connection.setDoInput(true);
                connection.setDoOutput(true);
                OutputStream ops = connection.getOutputStream();
                BufferedWriter writer = new BufferedWriter(new OutputStreamWriter(ops));

                String data = "customerID=" + customer.getAccID();

                writer.write(data);
                writer.flush();
                writer.close();
                ops.close();

                InputStream ips = connection.getInputStream();
                BufferedReader reader = new BufferedReader(new InputStreamReader(ips));
                StringBuffer buffer = new StringBuffer();
                String line = "";
                while ((line = reader.readLine()) != null) {
                    buffer.append(line + "\n");
                }
                String result = buffer.toString();
                if (result != null && result.length() > 0) {
                    JSONArray jsonArray = new JSONArray(result);
                    for (int i = 0; i < jsonArray.length(); i++) {
                            JSONObject reservationData = jsonArray.getJSONObject(i);
                            reservation =
                                    new Reservation(
                                            reservationData.getString("ReservationID"),
                                            reservationData.getString("RestaurantID"),
                                            reservationData.getString("CustomerID"),
                                            reservationData.getString("TableID"),
                                            reservationData.getString("ReservationDate"),
                                            reservationData.getString("ReservationsTime"),
                                            reservationData.getString("Status")
                                    );
                    }
                } else {
                    reservation = null;
                }
                connection.disconnect();
            } catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            } catch (JSONException e) {
                e.printStackTrace();
            }
            return reservation;
        }
        protected void onPostExecute(Reservation reservation) {
            super.onPostExecute(reservation);
            progressDialog.dismiss();
            callBack.done(reservation);
        }
    }

    public class startReservationAsyncTask extends AsyncTask<Void, Void, Boolean> {

        private Reservation reservation;
        private StartReservationCallBack callBack;
        private Boolean isSuccess = true;

        public startReservationAsyncTask(Reservation reservation, StartReservationCallBack callBack) {
            this.reservation = reservation;
            this.callBack = callBack;
        }
        @Override
        protected Boolean doInBackground(Void... voids) {
            try {
                URL url = new URL(SERVER_ADDRESS + "StartReservation.php");
                HttpURLConnection connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("POST");
                connection.setDoInput(true);
                connection.setDoOutput(true);
                OutputStream ops = connection.getOutputStream();
                BufferedWriter writer = new BufferedWriter(new OutputStreamWriter(ops));

                String data = "reservationId=" + reservation.getReservationID();
                writer.write(data);
                writer.flush();
                writer.close();
                ops.close();

                InputStream ips = connection.getInputStream();
                BufferedReader reader = new BufferedReader(new InputStreamReader(ips));
                StringBuffer buffer = new StringBuffer();
                String line = "";

                while ((line = reader.readLine()) != null) {
                    buffer.append(line + "\n");
                }
                String result = buffer.toString();

                if (result == null  && result.length() < 1) {
                    isSuccess = false;
                }
                connection.disconnect();
            }  catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }
            return isSuccess;
        }

        @Override
        protected void onPostExecute(Boolean isSuccess) {
            super.onPostExecute(isSuccess);
            progressDialog.dismiss();
            callBack.done(isSuccess);
        }
        }

    public class orderFoodAsyncTask extends AsyncTask<Void, Void, Boolean> {

        private Order order;
        private OrderFoodCallBack callBack;
        private Boolean isSuccess;
        private JSONArray foodJSONArray, qtyJSONArray;

        public orderFoodAsyncTask(Order food, OrderFoodCallBack callBack) {
            this.order = food;
            this.callBack = callBack;
        }
        @Override
        protected Boolean doInBackground(Void... voids) {
            try {
                URL url = new URL(SERVER_ADDRESS + "OrderFood.php");
                HttpURLConnection connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("POST");
                connection.setDoInput(true);
                connection.setDoOutput(true);
                OutputStream ops = connection.getOutputStream();
                BufferedWriter writer = new BufferedWriter(new OutputStreamWriter(ops));

                foodJSONArray = new JSONArray(order.getFoodItemCode());
                qtyJSONArray = new JSONArray(order.getQty());
                String data = "ReservationId=" + order.getReservationId() + "&Status=" + order.getStatus() +
                        "&Comments=" + order.getComments() + "&FoodArray=" + foodJSONArray + "&Qty=" + qtyJSONArray;
                writer.write(data);
                writer.flush();
                writer.close();
                ops.close();

                InputStream ips = connection.getInputStream();
                BufferedReader reader = new BufferedReader(new InputStreamReader(ips));
                StringBuffer buffer = new StringBuffer();
                String line = "";

                while ((line = reader.readLine()) != null) {
                    buffer.append(line + "\n");
                }
                String result = buffer.toString();
                if (result == null) {
                    isSuccess = false;
                } else {
                    isSuccess = true;
                }
                connection.disconnect();
            }  catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }
            return isSuccess;
        }
        @Override
        protected void onPostExecute(Boolean isSuccess) {
            super.onPostExecute(isSuccess);
            progressDialog.dismiss();
            callBack.done(isSuccess);
        }
    }

    public class callWaiterAsyncTask extends AsyncTask<Void, Void, Boolean> {

        private Reservation reservation;
        private CallWaiterCallBack callBack;
        private Boolean isSuccess;
        public callWaiterAsyncTask(Reservation gotReservation, CallWaiterCallBack callBack) {
            this.reservation = gotReservation;
            this.callBack = callBack;
        }
        @Override
        protected Boolean doInBackground(Void... voids) {
            try {
                URL url = new URL(SERVER_ADDRESS + "CallWaiter.php");
                HttpURLConnection connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("POST");
                connection.setDoInput(true);
                connection.setDoOutput(true);
                OutputStream ops = connection.getOutputStream();
                BufferedWriter writer = new BufferedWriter(new OutputStreamWriter(ops));

                String data = "tableId=" + reservation.getTableID();
                writer.write(data);
                writer.flush();
                writer.close();
                ops.close();

                InputStream ips = connection.getInputStream();
                BufferedReader reader = new BufferedReader(new InputStreamReader(ips));
                StringBuffer buffer = new StringBuffer();
                String line = "";

                while ((line = reader.readLine()) != null) {
                    buffer.append(line + "\n");
                }
                String result = buffer.toString();
                if (result == null) {
                    isSuccess = false;
                } else {
                    isSuccess = true;
                }
                connection.disconnect();
            }  catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }
            return isSuccess;
        }
        @Override
        protected void onPostExecute(Boolean isSuccess) {
            super.onPostExecute(isSuccess);
            progressDialog.dismiss();
            callBack.done(isSuccess);
        }
    }

    public class getAllOrderIDAsyncTask extends AsyncTask<Void, Void, ArrayList<Order>> {

        private Reservation reservation;
        private GetAllOrderIDCallBack callBack;
        private ArrayList<Order> orderArrayList = new ArrayList<>();

        public getAllOrderIDAsyncTask(Reservation gotReservation, GetAllOrderIDCallBack callBack) {
            this.reservation = gotReservation;
            this.callBack = callBack;
        }
        @Override
        protected ArrayList<Order> doInBackground(Void... voids) {
            try {
                URL url = new URL(SERVER_ADDRESS + "GetAllOrder.php");
                HttpURLConnection connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("POST");
                connection.setDoInput(true);
                connection.setDoOutput(true);
                OutputStream ops = connection.getOutputStream();
                BufferedWriter writer = new BufferedWriter(new OutputStreamWriter(ops));

                String data = "reservationId=" + reservation.getReservationID();
                writer.write(data);
                writer.flush();
                writer.close();
                ops.close();

                InputStream ips = connection.getInputStream();
                BufferedReader reader = new BufferedReader(new InputStreamReader(ips));
                StringBuffer buffer = new StringBuffer();
                String line = "";

                while ((line = reader.readLine()) != null) {
                    buffer.append(line + "\n");
                }
                String result = buffer.toString();
                if(result != null) {
                    JSONArray jsonArray = new JSONArray(result);
                    for (int i = 0; i < jsonArray.length(); i++) {
                        JSONObject jsonObject = jsonArray.getJSONObject(i);
                        Order order = new Order();
                        order.setId(jsonObject.getString("ID"));
                        order.setReservationId(jsonObject.getString("ReservationID"));
                        order.setStatus(jsonObject.getString("Status"));
                        order.setComments(jsonObject.getString("Comments"));
                        orderArrayList.add(order);
                    }
                }
                connection.disconnect();

            }  catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            } catch (JSONException e) {
                e.printStackTrace();
            }
            return orderArrayList;
        }
        @Override
        protected void onPostExecute(ArrayList orderIDArrayList) {
            super.onPostExecute(orderIDArrayList);
            progressDialog.dismiss();
            callBack.done(orderIDArrayList);
        }
    }

    public class getOrderFoodAsyncTask extends AsyncTask<Void, Void, ArrayList> {

        private ArrayList<OrderFood> orderFoodArrayList = new ArrayList<>();
        private GetOrderedFoodCallBack callBack;

        public getOrderFoodAsyncTask(GetOrderedFoodCallBack callBack) {
            this.callBack = callBack;
        }
        @Override
        protected ArrayList doInBackground(Void... voids) {
            try {
                URL url = new URL(SERVER_ADDRESS + "GetOrderedFood.php");
                HttpURLConnection connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("POST");
                connection.setDoInput(true);
                connection.setDoOutput(true);

                InputStream ips = connection.getInputStream();
                BufferedReader reader = new BufferedReader(new InputStreamReader(ips));
                StringBuffer buffer = new StringBuffer();
                String line = "";

                while ((line = reader.readLine()) != null) {
                    buffer.append(line + "\n");
                }
                String result = buffer.toString();
                if(result != null  && result.length() > 0) {
                    JSONArray jsonArray = new JSONArray(result);
                    for (int i = 0; i < jsonArray.length(); i++) {
                        JSONObject jsonObject = jsonArray.getJSONObject(i);
                        orderFoodArrayList.add(new OrderFood(
                                jsonObject.getString("OrderID"),
                                jsonObject.getString("FoodItemCode"),
                                jsonObject.getString("Qty")
                        ));
                    }
                }
                connection.disconnect();
            }  catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            } catch (JSONException e) {
                e.printStackTrace();
            }
            return orderFoodArrayList;
        }
        @Override
        protected void onPostExecute(ArrayList orderFoodArrayList) {
            super.onPostExecute(orderFoodArrayList);
            progressDialog.dismiss();
            callBack.done(orderFoodArrayList);
        }
    }

    public class getLocationAsyncTask extends AsyncTask<Void, Void, Location> {

        private Location location;
        private GetRestaurantLocationCallBack callBack;

        public getLocationAsyncTask(GetRestaurantLocationCallBack callBack) {
            this.callBack = callBack;
        }
        @Override
        protected Location doInBackground(Void... voids) {
            try {
                URL url = new URL(SERVER_ADDRESS + "GetLocation.php");
                HttpURLConnection connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("POST");
                connection.setDoInput(true);
                connection.setDoOutput(true);

                InputStream ips = connection.getInputStream();
                BufferedReader reader = new BufferedReader(new InputStreamReader(ips));
                StringBuffer buffer = new StringBuffer();
                String line = "";

                while ((line = reader.readLine()) != null) {
                    buffer.append(line + "\n");
                }
                String result = buffer.toString();
                if(result != null && result.length() > 0) {
                    JSONObject jsonObject = new JSONObject(result);
                    location = new Location(
                            jsonObject.getString("ID"),
                            Double.parseDouble(jsonObject.getString("Latitude")),
                            Double.parseDouble(jsonObject.getString("Longitude"))
                    );
                } else {
                    location = null;
                }
                connection.disconnect();
            }  catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            } catch (JSONException e) {
                e.printStackTrace();
            }
            return location;
        }
        @Override
        protected void onPostExecute(Location location) {
            super.onPostExecute(location);
            progressDialog.dismiss();
            callBack.done(location);
        }
    }

    public class payment extends AsyncTask<Void, Void, Boolean> {

        private String id, cardNum, securityCode, date;
        private PaymentCallBack callBack;
        private Boolean isSuccess;

        public payment(String id, String cardNum, String securityCode, String date, PaymentCallBack callBack) {
            this.id = id;
            this.cardNum = cardNum;
            this.securityCode = securityCode;
            this.date = date;
            this.callBack = callBack;
        }
        @Override
        protected Boolean doInBackground(Void... voids) {
            try {
                URL url = new URL(SERVER_ADDRESS + "Payment.php");
                HttpURLConnection connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("POST");
                connection.setDoInput(true);
                connection.setDoOutput(true);

                OutputStream ops = connection.getOutputStream();
                BufferedWriter writer = new BufferedWriter(new OutputStreamWriter(ops));

                String data = "reservationId=" + id + "&cardNum=" + cardNum + "&securityCode=" + securityCode + "&date=" + date;
                writer.write(data);
                writer.flush();
                writer.close();
                ops.close();

                InputStream ips = connection.getInputStream();
                BufferedReader reader = new BufferedReader(new InputStreamReader(ips));
                StringBuffer buffer = new StringBuffer();
                String line = "";

                while ((line = reader.readLine()) != null) {
                    buffer.append(line + "\n");
                }
                String result = buffer.toString();
                if(result != null && result.length() > 0) {
                    isSuccess = true;
                } else {
                    isSuccess = false;
                }
                connection.disconnect();
            }  catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }
            return isSuccess;
        }
        @Override
        protected void onPostExecute(Boolean isSuccess) {
            super.onPostExecute(isSuccess);
            progressDialog.dismiss();
            callBack.done(isSuccess);
        }
    }
}