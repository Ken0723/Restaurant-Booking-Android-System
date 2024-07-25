package com.example.fyp;

import android.app.Dialog;
import android.content.Context;
import android.content.DialogInterface;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
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
import java.util.Collections;

public class Dialog_OrderFood extends AppCompatDialogFragment {

    private ListView lvOrderFood;
    private ArrayList<Food> foodArrayList;
    public ArrayList foodItemArrayList = new ArrayList(), qtyArrayList = new ArrayList();
    private EditText etComment;
    private Order orderFood;
    private Customer customer;
    private Reservation reservation;
    private Context pContext;

    public Dialog onCreateDialog(Bundle savedInstanceState) {
        AlertDialog.Builder builder = new AlertDialog.Builder(getActivity());
        LayoutInflater inflater = getActivity().getLayoutInflater();
        View view = inflater.inflate(R.layout.dialog_orderfood, null);
        pContext = getContext();

        lvOrderFood = view.findViewById(R.id.lvOrderFood);
        etComment = view.findViewById(R.id.etComment);

        builder.setView(view)
                .setTitle("Order Food")
                .setNegativeButton("Cancel", null)
                .setPositiveButton("Submit", new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                int count = qtyArrayList.size();
                                ArrayList<Integer> test = new ArrayList();
                                for (int i = 0; i < count; i++) {
                                    if (qtyArrayList.get(i).equals(0)) {
                                        test.add(i);
                                    }
                                }
                                if (test.size() > 0) {
                                    Collections.sort(test, Collections.<Integer>reverseOrder());
                                    for (int k = 0; k < test.size(); k++) {
                                        int pos = test.get(k);
                                        qtyArrayList.remove(new Integer(pos));
                                        foodItemArrayList.remove(foodItemArrayList.get(pos) + "");
                                    }
                                }
                                orderFood = new Order("", reservation.getReservationID(), "Sent", etComment.getText().toString(), foodItemArrayList, qtyArrayList);
                                ServerRequests serverRequests = new ServerRequests(getContext());
                                serverRequests.orderFood(orderFood, new OrderFoodCallBack() {
                                    @Override
                                    public void done(Boolean isSuccess) {
                                        if (isSuccess) {
                                            Toast.makeText(pContext,"Order completed, please wait", Toast.LENGTH_SHORT).show();
                                        } else {
                                            AlertDialog.Builder builder = new AlertDialog.Builder(pContext);
                                            builder.setMessage("Order food failed, \nplease try again or contact staff!")
                                                    .setPositiveButton("OK", null).show();
                                        }
                                    }
                                });
                            }
                });
        getAllFood();
        return builder.create();
    }
    public void getAllFood() {
        ServerRequests serverRequests = new ServerRequests(getContext());
        serverRequests.getAllFood(new GetAllFoodCallBack() {
            @Override
            public void done(ArrayList foodArray) {
                if (foodArray == null) {
                    AlertDialog.Builder builder = new AlertDialog.Builder(pContext);
                    builder.setMessage("Cannot find any food, please try again")
                            .setPositiveButton("OK", new DialogInterface.OnClickListener() {
                                @Override
                                public void onClick(DialogInterface dialog, int which) {
                                    getActivity().finish();
                                }
                            }).show();
                } else {
                    loopToListView(foodArray);
                }
            }
        });
    }
    public void getData(Customer gotCustomer, Reservation gotReservation) {
        customer = gotCustomer;
        reservation = gotReservation;
    }
    public void loopToListView(ArrayList<Food> foodArray) {
        foodArrayList = foodArray;
        for (int i = 0; i < foodArrayList.size(); i++) {
            Food food = foodArrayList.get(i);
            foodItemArrayList.add(food.getCode());
            qtyArrayList.add(0);
        }
        FoodAdapter foodAdapter = new FoodAdapter();
        lvOrderFood.setAdapter(foodAdapter);
    }
    public class FoodAdapter extends BaseAdapter {

        @Override
        public int getCount() {
            return foodArrayList.size();
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
            convertView = getLayoutInflater().inflate(R.layout.view_orderfood, null);

            TextView tvName = convertView.findViewById(R.id.tvName);
            TextView tvDes = convertView.findViewById(R.id.tvDes);
            final EditText etQty = convertView.findViewById(R.id.etQty);

            Food food = foodArrayList.get(position);

            tvName.setText(food.getName());
            tvDes.setText(food.getDescription());
            etQty.setTag(position);

            etQty.addTextChangedListener(new TextWatcher() {
                @Override
                public void beforeTextChanged(CharSequence s, int start, int count, int after) {

                }

                @Override
                public void onTextChanged(CharSequence s, int start, int before, int count) {
                    int index = Integer.parseInt(etQty.getTag().toString());
                    qtyArrayList.set(index, etQty.getText().toString());
                }

                @Override
                public void afterTextChanged(Editable s) {

                }
            });

            return convertView;
        }
    }

}
