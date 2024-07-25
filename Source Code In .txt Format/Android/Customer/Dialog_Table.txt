package com.example.fyp;

import android.app.DatePickerDialog;
import android.app.Dialog;
import android.content.Context;
import android.icu.util.Calendar;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatDialogFragment;
import java.text.DateFormat;
import java.util.ArrayList;

public class Dialog_Table extends AppCompatDialogFragment {

    private TextView tvDate, tvStatus, tvTableSize;
    private TextView tv1300, tv1500, tv1700, tv1900, tv2100;
    private TextView displayStatus1300, displayStatus1500, displayStatus1700, displayStatus1900, displayStatus2100;
    private Button btnSelect, btnSearch, btnBookSeat;
    private DateFormat fmrDate = DateFormat.getDateInstance();
    private DatePickerDialog.OnDateSetListener d;
    private Calendar calendar = Calendar.getInstance();
    private Calendar now = Calendar.getInstance();
    private Table table;
    private Customer customer;
    private ArrayList<Reservation> reservationArray = new ArrayList<Reservation>();
    private Context pContext;

    public Dialog onCreateDialog(Bundle savedInstanceState) {
            AlertDialog.Builder builder = new AlertDialog.Builder(getActivity());
            LayoutInflater inflater = getActivity().getLayoutInflater();
            View view = inflater.inflate(R.layout.dialog_table, null);
            pContext = getContext();

            btnSelect = view.findViewById(R.id.btnSelect);
            btnSearch = view.findViewById(R.id.btnSearch);
            btnBookSeat = view.findViewById(R.id.btnBookSeat);
            tvDate = view.findViewById(R.id.txtDisaplyDate);
            tvStatus = view.findViewById(R.id.txtTableStatus);
            tvTableSize = view.findViewById(R.id.txtTableSize);

            tv1300 = view.findViewById(R.id.tv1300);
            tv1500 = view.findViewById(R.id.tv1500);
            tv1700 = view.findViewById(R.id.tv1700);
            tv1900 = view.findViewById(R.id.tv1900);
            tv2100 = view.findViewById(R.id.tv2100);

            displayStatus1300 = view.findViewById(R.id.displayStatus1300);
            displayStatus1500 = view.findViewById(R.id.displayStatus1500);
            displayStatus1700 = view.findViewById(R.id.displayStatus1700);
            displayStatus1900 = view.findViewById(R.id.displayStatus1900);
            displayStatus2100 = view.findViewById(R.id.displayStatus2100);

            updateData();

            builder.setView(view)
                    .setTitle("Table: " + table.getID())
                    .setNegativeButton("Close", null);

            d = new DatePickerDialog.OnDateSetListener() {
                @Override
                public void onDateSet(DatePicker view, int year, int month, int dayOfMonth) {
                    calendar.set(Calendar.YEAR, year);
                    calendar.set(Calendar.MONTH, month);
                    calendar.set(Calendar.DAY_OF_MONTH, dayOfMonth);
                    updateLabel();
                }
            };

            btnSelect.setOnClickListener(new View.OnClickListener() {
                public void onClick(View v) {
                    DatePickerDialog dpd = new DatePickerDialog(getActivity(), d,
                            calendar.get(Calendar.YEAR),
                            calendar.get(Calendar.MONTH),
                            calendar.get(Calendar.DAY_OF_MONTH));

                    dpd.getDatePicker().setMinDate(now.getTimeInMillis() + (1000*60*60*24));
                    dpd.show();
                }
            });
            btnSearch.setOnClickListener(new View.OnClickListener() {
                public void onClick(View v) {
                    if (tvDate != null && tvDate.length() > 0) {
                        ServerRequests serverRequests = new ServerRequests(getActivity());
                        serverRequests.getReservation(table, tvDate.getText().toString(), new GetReservationCallBack() {
                            @Override
                            public void done(ArrayList returnedData) {
                                if (returnedData != null) {
                                    Reservation data;
                                    reservationArray = returnedData;
                                    tv1300.setVisibility(View.VISIBLE);
                                    tv1500.setVisibility(View.VISIBLE);
                                    tv1700.setVisibility(View.VISIBLE);
                                    tv1900.setVisibility(View.VISIBLE);
                                    tv2100.setVisibility(View.VISIBLE);
                                    displayStatus1300.setVisibility(View.VISIBLE);
                                    displayStatus1500.setVisibility(View.VISIBLE);
                                    displayStatus1700.setVisibility(View.VISIBLE);
                                    displayStatus1900.setVisibility(View.VISIBLE);
                                    displayStatus2100.setVisibility(View.VISIBLE);

                                    for (int i = 0; i < reservationArray.size(); i++) {
                                        data = reservationArray.get(i);
                                        if (data.getTime().equals("13:00:00") && data.getStatus().equals("Booked")) {
                                            displayStatus1300.setText("Booked");
                                        }
                                        if (data.getTime().equals("15:00:00") && data.getStatus().equals("Booked")) {
                                            displayStatus1500.setText("Booked");
                                        }
                                        if (data.getTime().equals("17:00:00") && data.getStatus().equals("Booked")) {
                                            displayStatus1700.setText("Booked");
                                        }
                                        if (data.getTime().equals("19:00:00") && data.getStatus().equals("Booked")) {
                                            displayStatus1900.setText("Booked");
                                        }
                                        if (data.getTime().equals("21:00:00") && data.getStatus().equals("Booked")) {
                                            displayStatus2100.setText("Booked");
                                        }
                                    }
                                } else {
                                    tv1300.setVisibility(View.VISIBLE);
                                    tv1500.setVisibility(View.VISIBLE);
                                    tv1700.setVisibility(View.VISIBLE);
                                    tv1900.setVisibility(View.VISIBLE);
                                    tv2100.setVisibility(View.VISIBLE);
                                    displayStatus1300.setVisibility(View.VISIBLE);
                                    displayStatus1500.setVisibility(View.VISIBLE);
                                    displayStatus1700.setVisibility(View.VISIBLE);
                                    displayStatus1900.setVisibility(View.VISIBLE);
                                    displayStatus2100.setVisibility(View.VISIBLE);
                                    displayStatus1300.setText("Available");
                                    displayStatus1500.setText("Available");
                                    displayStatus1700.setText("Available");
                                    displayStatus1900.setText("Available");
                                    displayStatus2100.setText("Available");
                                }
                            }
                        });
                    } else {
                        Toast.makeText(pContext, "Please select the date!", Toast.LENGTH_SHORT).show();
                    }
                }
            });
            btnBookSeat.setOnClickListener(new View.OnClickListener() {
                public void onClick(View v) {
                    Dialog_Book_Seat dialog_book_seat = new Dialog_Book_Seat();
                    dialog_book_seat.getData(customer, table);
                    dialog_book_seat.show(getFragmentManager(), "Booking seat dialog");
                }
            });
            return builder.create();
    }
    public void updateLabel() {
        tvDate.setText(fmrDate.format(calendar.getTime()));
    }
    public void getData(Table tableData, Customer customerData) {
        table = tableData;
        customer = customerData;
    }

    public void updateData() {
        if (table.getStatus().equals("Calling")) {
            tvStatus.setText("Status: " + "Seated" + "(Now)");
        } else {
            tvStatus.setText("Status: " + table.getStatus() + "(Now)");
        }
        tvTableSize.setText("Table size: " + table.getTableSize() + "");
    }
}

