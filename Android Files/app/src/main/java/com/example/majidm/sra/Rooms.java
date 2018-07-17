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
import java.util.List;

public class Rooms extends AppCompatActivity {

    Spinner spinner ;
    List<String> rooms_ids = new ArrayList<String>();
    List<String> rooms_names = new ArrayList<String>();
    ArrayAdapter<String> dataAdapter;
    int x = 0 ;
    TextView room_txt , time_txt , date_txt ;
    String reserve_date , reserve_time, room_id , user_id ;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_rooms);

        room_txt = (TextView)findViewById(R.id.room_txt);
        time_txt = (TextView)findViewById(R.id.time_txt_r);
        date_txt = (TextView)findViewById(R.id.date_txt_r);

        //-------- Getting user id from session Data -----------
        SharedPreferences sharedPreferences = PreferenceManager.getDefaultSharedPreferences(getApplicationContext());
        user_id = sharedPreferences.getString("session_uid","0") ;

        //-----------------Spinner Related Code -----------------
        spinner = (Spinner)findViewById(R.id.rooms_spinner);
        // Creating adapter for spinner
        dataAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, rooms_names);
        // Drop down layout style - list view with radio button
        dataAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        // attaching data adapter to spinner
        spinner.setAdapter(dataAdapter);

        spinner.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener(){
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                room_id = rooms_ids.get(position);  //This will be room  id.
                room_txt.setText("Selected Room: "+parent.getItemAtPosition(position));

            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });
        if(x==0){
            BackgroundWorker_Rooms bgworker = new BackgroundWorker_Rooms(this);
            bgworker.execute();
        }
        x++;
    } //-------------- OnCreate Ends Here --------------

    public void onSelectTime_r(View v){
        TimePickerDialog mTimePicker;
        mTimePicker = new TimePickerDialog(Rooms.this, new TimePickerDialog.OnTimeSetListener() {
            @Override
            public void onTimeSet(TimePicker timePicker, int selectedHour, int selectedMinute) {
                reserve_time = selectedHour + ":" + selectedMinute ;
                time_txt.setText("Selected Time: "+reserve_time);
            }
        }, 2, 30, true);//Yes 24 hour time
        mTimePicker.setTitle("Select Time");
        mTimePicker.show();
    }

    public void onSelectDate_r(View v){
        DatePickerDialog mDatePicker ;
        mDatePicker = new DatePickerDialog(Rooms.this, new DatePickerDialog.OnDateSetListener() {
            @Override
            public void onDateSet(DatePicker view, int year, int month, int dayOfMonth) {
                reserve_date = year + ":" + (month+1)+":"+dayOfMonth ;
                date_txt.setText("Selected Date: "+reserve_date);
            }
        },2018,04,11);
        mDatePicker.setTitle("Select Date");
        mDatePicker.show();
    }

    public void onReserve_r(View v){

        if(!user_id.equals("") && !room_id.equals("") && !reserve_date.equals("") && !reserve_time.equals("")){
            BackgroundWorker_ReserveRooms bgw = new BackgroundWorker_ReserveRooms(this);
            bgw.execute();
        }
    }

    //-----------------Inner class to fetch all Rooms --------------------------
    class BackgroundWorker_Rooms extends AsyncTask<String, String, String> {

        Context context;
        BackgroundWorker_Rooms (Context ctx) {
            context = ctx;
        }

        @Override
        protected String doInBackground(String... params) {

            String test_url = "http://172.20.10.2/rms2/API/rooms.php";

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
                JSONArray rooms =(new JSONObject(result)).getJSONArray("rooms");
                for (int i=0; i<rooms.length(); i++){
                    String room_id = rooms.getJSONObject(i).getString("partyhall_id");
                    String room_name = rooms.getJSONObject(i).getString("partyhall_name");
                    rooms_names.add(room_name);
                    rooms_ids.add(room_id);
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
    class BackgroundWorker_ReserveRooms extends AsyncTask<String, String, String> {

        Context context;
        BackgroundWorker_ReserveRooms (Context ctx) {
            context = ctx;
        }

        @Override
        protected String doInBackground(String... params) {

            String test_url = "http://172.20.10.2/rms2/API/reserve_room.php";

            try {
                URL url = new URL(test_url);
                HttpURLConnection httpURLConnection = (HttpURLConnection)url.openConnection();
                httpURLConnection.setRequestMethod("POST");
                httpURLConnection.setDoOutput(true);
                httpURLConnection.setDoInput(true);
                OutputStream outputStream = httpURLConnection.getOutputStream();
                BufferedWriter bufferedWriter = new BufferedWriter(new OutputStreamWriter(outputStream, "UTF-8"));
                String post_data = URLEncoder.encode("room_id","UTF-8")+"="+URLEncoder.encode(room_id,"UTF-8")+"&"
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
