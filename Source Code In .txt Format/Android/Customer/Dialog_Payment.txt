package com.example.fyp;

import android.app.Dialog;
import android.content.Context;
import android.content.DialogInterface;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatDialogFragment;

public class Dialog_Payment extends AppCompatDialogFragment {

    private String reservationId;
    private EditText etCardNum, etSecurityCode, etDate;
    private Context pContext;

    public Dialog onCreateDialog(Bundle savedInstanceState) {
        AlertDialog.Builder builder = new AlertDialog.Builder(getActivity());
        LayoutInflater inflater = getActivity().getLayoutInflater();
        View view = inflater.inflate(R.layout.dialog_payment, null);
        pContext = getContext();

        etCardNum = view.findViewById(R.id.etCardNum);
        etSecurityCode = view.findViewById(R.id.etSecurityCode);
        etDate = view.findViewById(R.id.etDate);

        builder.setView(view)
                .setTitle("Reservation: " + reservationId)
                .setNegativeButton("Close", null)
                .setPositiveButton("Submit", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        ServerRequests serverRequests = new ServerRequests(getContext());
                        serverRequests.payment(reservationId, etCardNum.getText().toString(), etSecurityCode.getText().toString(), etDate.getText().toString(), new PaymentCallBack() {
                            @Override
                            public void done(Boolean isSuccess) {
                                showMessage(isSuccess);
                            }
                        });
                    }
                });


        return builder.create();
    }
    public void getData(String id) {
        reservationId = id;
    }
    public void showMessage(Boolean isSuccess) {
        if (isSuccess) {
            Toast.makeText(pContext, "Payment finished\nplease reload this page to see the changed!", Toast.LENGTH_LONG).show();
        } else {
            Toast.makeText(pContext, "Payment not finish, please try again", Toast.LENGTH_LONG).show();

        }
    }
}
