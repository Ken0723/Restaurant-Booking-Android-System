package com.example.fyp;

import android.app.Dialog;
import android.content.Context;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatDialogFragment;


import java.util.ArrayList;

public class Dialog_AllOrderedFood extends AppCompatDialogFragment {

    private ArrayList<Order> orderArrayList = new ArrayList<>();
    private ArrayList<OrderFood> orderFoodArrayList = new ArrayList<>();
    private ArrayList<Food> foodArrayList = new ArrayList<>();
    private ListView lvOrder;
    private String OrderId = "";
    private Context pContext;

    public Dialog onCreateDialog(Bundle savedInstanceState) {
        AlertDialog.Builder builder = new AlertDialog.Builder(getActivity());
        LayoutInflater inflater = getActivity().getLayoutInflater();
        View view = inflater.inflate(R.layout.dialog_allorderedfood, null);
        pContext = getContext();

        lvOrder = view.findViewById(R.id.lvOrder);

        builder.setView(view)
                .setPositiveButton("Close", null);
        getAllFood();
        getOrderedFood();
        return builder.create();
    }
    public void getAllFood() {
        ServerRequests serverRequests = new ServerRequests(pContext);
        serverRequests.getAllFood(new GetAllFoodCallBack() {
            @Override
            public void done(ArrayList arrayList) {
                if (arrayList != null && arrayList.size() > 0) {
                    foodArrayList = arrayList;
                } else {
                    Toast.makeText(pContext, "Cannot get the food list", Toast.LENGTH_SHORT).show();
                }
            }
        });
    }
    public void getData(ArrayList<Order> gotArrayList) {
        orderArrayList = gotArrayList;
    }
    public void setAdapter() {
        OrderFoodAdapter orderFoodAdapter = new OrderFoodAdapter();
        lvOrder.setAdapter(orderFoodAdapter);
    }
    public void getOrderedFood() {
          ServerRequests serverRequests = new ServerRequests(getContext());
            serverRequests.getOrderFood(new GetOrderedFoodCallBack() {
                @Override
                public void done(ArrayList<OrderFood> orderedFoodArrayList) {
                    if (orderedFoodArrayList != null) {
                        orderFoodArrayList = orderedFoodArrayList;
                        Log.e("Check Array list size", orderFoodArrayList.size() + " | " + orderedFoodArrayList.size());
                        setAdapter();
                    } else {
                        Toast.makeText(pContext, "Cannot find any order", Toast.LENGTH_SHORT).show();
                    }
                }
            });
    }
    public class OrderFoodAdapter extends BaseAdapter {

        @Override
        public int getCount() {
            return orderArrayList.size();
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
            convertView = getLayoutInflater().inflate(R.layout.view_allorderedfood, null);

            TextView tvOrderId = convertView.findViewById(R.id.tvOrderId);
            TextView tvStatus = convertView.findViewById(R.id.tvStatus);
            EditText etComments = convertView.findViewById(R.id.etComments);
            EditText etFood = convertView.findViewById(R.id.etFood);

            Order order = orderArrayList.get(position);
            OrderId = order.getId();
            tvOrderId.setText("Order ID: " + order.getId());
            tvStatus.setText(order.getStatus());
            etComments.setText(order.getComments());

            for (int i = 0; i < orderFoodArrayList.size();i++){
                OrderFood orderFood = orderFoodArrayList.get(i);
                if (orderFood.getOrderID().equals(OrderId)) {
                    String foodName = "";
                    for(int k = 0; k < foodArrayList.size(); k++) {
                        Food food = foodArrayList.get(k);
                        if (food.getCode().equals(orderFood.getFoodItemCode())) {
                            foodName = food.getName();
                            break;
                        }
                    }
                    String qty = orderFood.getQty();
                    String data = foodName + "\tX\t" + qty + "\n";
                    etFood.setText(etFood.getText().toString() + data);
                }
            }
            return convertView;
        }
    }
}
