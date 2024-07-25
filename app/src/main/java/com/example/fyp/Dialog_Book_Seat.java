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
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatDialogFragment;

import java.text.DateFormat;

public class Dialog_Book_Seat extends AppCompatDialogFragment {

    private TextView book_display_date;
    private Button book_btnSelect, book_submit;
    private Spinner book_sp_Time;
    private DateFormat fmrDate = DateFormat.getDateInstance();
    private DatePickerDialog.OnDateSetListener d;
    private Calendar calendar = Calendar.getInstance();
    private Calendar now = Calendar.getInstance();
    private Customer customer;
    private Table table;
    private Context pContext;

    public Dialog onCreateDialog(Bundle savedInstanceState) {
        AlertDialog.Builder builder = new AlertDialog.Builder(getActivity());
        LayoutInflater inflater = getActivity().getLayoutInflater();
        View view = inflater.inflate(R.layout.dialog_bookseat, null);
        pContext = getContext();

        book_display_date = view.findViewById(R.id.book_tv_DIsplaydate);
        book_btnSelect = view.findViewById(R.id.btnSelectDate);
        book_sp_Time = view.findViewById(R.id.book_sp_Time);
        book_submit = view.findViewById(R.id.btnSubmit);

        builder.setView(view)
                .setTitle("Booking Seat")
                .setNegativeButton("Cancel", null);

        d = new DatePickerDialog.OnDateSetListener() {
            @Override
            public void onDateSet(DatePicker view, int year, int month, int dayOfMonth) {
                calendar.set(Calendar.YEAR, year);
                calendar.set(Calendar.MONTH, month);
                calendar.set(Calendar.DAY_OF_MONTH, dayOfMonth);
                updateLabel();
            }
        };
        book_btnSelect.setOnClickListener(new View.OnClickListener() {
            public void onClick(View v) {
                DatePickerDialog dpd = new DatePickerDialog(getActivity(), d,
                        calendar.get(Calendar.YEAR),
                        calendar.get(Calendar.MONTH),
                        calendar.get(Calendar.DAY_OF_MONTH));

                dpd.getDatePicker().setMinDate(now.getTimeInMillis() + (1000*60*60*24*3));
                dpd.show();
            }
        });
        book_submit.setOnClickListener(new View.OnClickListener() {
            public void onClick(View v) {
                String time = book_sp_Time.getSelectedItem().toString();
                String date = book_display_date.getText().toString();
                if (date != null && date.length() > 0) {
                    ServerRequests serverRequests = new ServerRequests(getActivity());
                    serverRequests.bookingSeat(customer, table, time, date, new GetBookingCallBack() {
                        @Override
                        public void done(boolean isSuccess) {
                            if (isSuccess) {
                                AlertDialog.Builder builder = new AlertDialog.Builder(getActivity());
                                builder.setMessage("Booking seat completed, \nplease finish the payment")
                                        .setPositiveButton("OK", null).show();
                                completeBooking();
                            } else {
                                AlertDialog.Builder builder = new AlertDialog.Builder(getActivity());
                                builder.setMessage("Sorry, booking seat failed, \nplease make sure you enter all information and check the date is it had been booked")
                                        .setPositiveButton("OK", null).show();
                            }
                        }
                    });
                } else {
                    Toast.makeText(pContext, "Please select the date!", Toast.LENGTH_SHORT).show();
                }
            }
        });
        return builder.create();
    }
    public void updateLabel() {
        book_display_date.setText(fmrDate.format(calendar.getTime()));
    }
    public void getData(Customer customer, Table table) {
        this.customer = customer;
        this.table = table;
    }
    public void completeBooking() {
        this.dismiss();
    }
}
