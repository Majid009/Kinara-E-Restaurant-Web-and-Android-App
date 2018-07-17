package com.example.majidm.sra;

import android.app.DatePickerDialog;
import android.app.TimePickerDialog;
import android.content.Context;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.preference.PreferenceManager;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.DatePicker;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.TimePicker;
import android.widget.Toast;

import org.json.JSONArray;
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
import java.net.URLEncoder;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.HashMap;
import java.util.List;

public class Tables extends AppCompatActivity {

    Spinner spinner ;
    List<String> tables_ids = new ArrayList<String>();
    List<String> tables_names = new ArrayList<String>();
    ArrayAdapter<String> dataAdapter;
    int x = 0 ;
    TextView table_txt , time_txt , date_txt ;
    String reserve_date , reserve_time, table_id , user_id ;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_tables);

        table_txt = (TextView)findViewById(R.id.table_txt);
        time_txt = (TextView)findViewById(R.id.time_txt);
        date_txt = (TextView)findViewById(R.id.date_txt);

        //-------- Getting user id from session Data -----------
        SharedPreferences sharedPreferences = PreferenceManager.getDefaultSharedPreferences(getApplicationContext());
        user_id = sharedPreferences.getString("session_uid","0") ;

        //-----------------Spinner Related Code -----------------
        spinner = (Spinner)findViewById(R.id.tables_spinner);
        // Creating adapter for spinner
        dataAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, tables_names);
        // Drop down layout style - list view with radio button
        dataAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        // attaching data adapter to spinner
        spinner.setAdapter(dataAdapter);

        spinner.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener(){
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                table_id = tables_ids.get(position);  //This will be table  id.
                table_txt.setText("Selected Table: "+parent.getItemAtPosition(position));
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });

        if(x==0){
            BackgroundWorker_Tables bgworker = new BackgroundWorker_Tables(this);
            bgworker.execute();
        }
        x++;

    }  //--------- onCreate Ends Here  ---------------------

    public void onSelectTime(View v){
        TimePickerDialog mTimePicker;
        mTimePicker = new TimePickerDialog(Tables.this, new TimePickerDialog.OnTimeSetListener() {
            @Override
            public void onTimeSet(TimePicker timePicker, int selectedHour, int selectedMinute) {
                reserve_time = selectedHour + ":" + selectedMinute ;
                time_txt.setText("Selected Time: "+reserve_time);
            }
        }, 2, 30, true);//Yes 24 hour time
        mTimePicker.setTitle("Select Time");
        mTimePicker.show();
    }

    public void onSelectDate(View v){
        DatePickerDialog mDatePicker ;
        mDatePicker = new DatePickerDialog(Tables.this, new DatePickerDialog.OnDateSetListener() {
            @Override
            public void onDateSet(DatePicker view, int year, int month, int dayOfMonth) {
                reserve_date = year + ":" + (month+1)+":"+dayOfMonth ;
                date_txt.setText("Selected Date: "+reserve_date);
            }
        },2018,04,11);
        mDatePicker.setTitle("Select Date");
        mDatePicker.show();
    }

    public void onReserve(View v){

        if(!user_id.equals("") && !table_id.equals("") && !reserve_date.equals("") && !reserve_time.equals("")){
            BackgroundWorker_ReserveTables bgw = new BackgroundWorker_ReserveTables(this);
            bgw.execute();
        }
    }

    //-----------------Inner class to fetch all Tables --------------------------
    class BackgroundWorker_Tables extends AsyncTask<String, String, String> {

        Context context;
        BackgroundWorker_Tables (Context ctx) {
            context = ctx;
        }

        @Override
        protected String doInBackground(String... params) {

            String test_url = "http://172.20.10.2/rms2/API/tables.php";

            try {
                URL url = new URL(test_url);
                HttpURLConnection httpURLConnection = (HttpURLConnection)url.openConnection();
                httpURLConnection.setRequestMethod("POST");
                httpURLConnection.setDoOutput(true);
                httpURLConnection.setDoInput(true);
                OutputStream outputStream = httpURLConnection.getOutputStream();
                BufferedWriter bufferedWriter = new BufferedWriter(new OutputStreamWriter(outputStream, "UTF-8"));
                String post_data = URLEncoder.encode("fname","UTF-8")+"="+URLEncoder.encode("Majid","UTF-8");
                bufferedWriter.write(post_data);
                bufferedWriter.flush();
                bufferedWriter.close();
                outputStream.close();
                InputStream inputStream = httpURLConnection.getInputStream();
                BufferedReader bufferedReader = new BufferedReader(new InputStreamReader(inputStream,"iso-8859-1"));
                String result="";
                String line="";
                while((line = bufferedReader.readLine())!= null) {
                    result += line;
                }
                bufferedReader.close();
                inputStream.close();
                httpURLConnection.disconnect();
                return result;
            } catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }

            return null;
        }

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
        }

        @Override
        protected void onPostExecute(String result) {
            try{
                JSONArray tables =(new JSONObject(result)).getJSONArray("tables");
                for (int i=0; i<tables.length(); i++){
                    String table_id = tables.getJSONObject(i).getString("table_id");
                    String table_name = tables.getJSONObject(i).getString("table_name");
                    tables_names.add(table_name);
                    tables_ids.add(table_id);
                    dataAdapter.notifyDataSetChanged();
                }
            }catch (Exception e) {e.printStackTrace();}

        }


        @Override
        protected void onProgressUpdate(String... values) {
            super.onProgressUpdate(values);
        }
    } // ---------- First inner class Ends here  -----------------

    //-----------------Inner class to reserve Table--------------------------
    class BackgroundWorker_ReserveTables extends AsyncTask<String, String, String> {

        Context context;
        BackgroundWorker_ReserveTables (Context ctx) {
            context = ctx;
        }

        @Override
        protected String doInBackground(String... params) {

            String test_url = "http://172.20.10.2/rms2/API/reserve_table.php";

            try {
                URL url = new URL(test_url);
                HttpURLConnection httpURLConnection = (HttpURLConnection)url.openConnection();
                httpURLConnection.setRequestMethod("POST");
                httpURLConnection.setDoOutput(true);
                httpURLConnection.setDoInput(true);
                OutputStream outputStream = httpURLConnection.getOutputStream();
                BufferedWriter bufferedWriter = new BufferedWriter(new OutputStreamWriter(outputStream, "UTF-8"));
                String post_data = URLEncoder.encode("table_id","UTF-8")+"="+URLEncoder.encode(table_id,"UTF-8")+"&"
                        +URLEncoder.encode("user_id","UTF-8")+"="+URLEncoder.encode(user_id,"UTF-8")+"&"
                        +URLEncoder.encode("date","UTF-8")+"="+URLEncoder.encode(reserve_date,"UTF-8")+"&"
                        +URLEncoder.encode("time","UTF-8")+"="+URLEncoder.encode(reserve_time,"UTF-8")+"&";
                bufferedWriter.write(post_data);
                bufferedWriter.flush();
                bufferedWriter.close();
                outputStream.close();
                InputStream inputStream = httpURLConnection.getInputStream();
                BufferedReader bufferedReader = new BufferedReader(new InputStreamReader(inputStream,"iso-8859-1"));
                String result="";
                String line="";
                while((line = bufferedReader.readLine())!= null) {
                    result += line;
                }
                bufferedReader.close();
                inputStream.close();
                httpURLConnection.disconnect();
                return result;
            } catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }

            return null;
        }


        @Override
        protected void onPreExecute() {
            super.onPreExecute();
        }

        @Override
        protected void onPostExecute(String result) {
            Toast.makeText(context,result,Toast.LENGTH_SHORT).show();
        }


        @Override
        protected void onProgressUpdate(String... values) {
            super.onProgressUpdate(values);
        }
    }


}
