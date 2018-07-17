package com.example.majidm.sra;

import android.app.ActionBar;
import android.app.DatePickerDialog;
import android.app.Dialog;
import android.app.TimePickerDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.DatePicker;
import android.widget.TimePicker;
import android.widget.Toast;

public class Wellcome extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_wellcome);
    }

    public void onLogin(View v) {
        Intent i = new Intent(this , login.class);
        startActivity(i);
    }

    public void onRegister(View v)
    {
        Intent i = new Intent(this , register.class);
        startActivity(i);
    }

    public void on_db_login(View v){

     Intent i = new Intent(this,db_login.class);
     startActivity(i);

    }


}
