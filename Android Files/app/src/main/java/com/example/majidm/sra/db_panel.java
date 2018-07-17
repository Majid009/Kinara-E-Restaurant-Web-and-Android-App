package com.example.majidm.sra;

import android.Manifest;
import android.content.Context;
import android.content.SharedPreferences;
import android.content.pm.PackageManager;
import android.location.Location;
import android.location.LocationManager;
import android.os.AsyncTask;
import android.os.Handler;
import android.preference.PreferenceManager;
import android.support.v4.app.ActivityCompat;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TextView;
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

public class db_panel extends AppCompatActivity {

    final static int REQUEST_CODE = 1;
    public LocationManager lm;
    double current_location_latitude = 0;
    double current_location_longitutde = 0;
    String staff_id;
    ListView listView ;
    List<String> orders_details = new ArrayList<String>();
    List<String> orders_ids = new ArrayList<String>();
    ArrayAdapter<String> dataAdapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_db_panel);

        listView = (ListView)findViewById(R.id.order_list);
        dataAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, orders_details);
        listView.setAdapter(dataAdapter);

        lm = (LocationManager) getSystemService(Context.LOCATION_SERVICE);

        SharedPreferences sharedPreferences = PreferenceManager.getDefaultSharedPreferences(getApplicationContext());
        staff_id = sharedPreferences.getString("session_db_id", "0");

        BackgroundWorker_Orders backgroundWorker_orders = new BackgroundWorker_Orders(this);
        backgroundWorker_orders.execute();

        final Handler handler = new Handler();
        final int delay = 9000; //milliseconds
        handler.postDelayed(new Runnable() {
            public void run() {
                //do something
                getMyLocation();
                BackgroundWorker_Location bgworker = new BackgroundWorker_Location(getApplicationContext());
                bgworker.execute();
                //Toast.makeText(getApplicationContext(),"i am Live",Toast.LENGTH_SHORT).show();
                handler.postDelayed(this, delay);
            }
        }, delay);

    } //-----------------------OnCreate Ends Here -------------

    // update the current location of user
    public void getMyLocation() {
        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) !=
                PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_COARSE_LOCATION)
                != PackageManager.PERMISSION_GRANTED) {
            ActivityCompat.requestPermissions(this, new String[]{Manifest.permission.ACCESS_FINE_LOCATION}, REQUEST_CODE);
        } else {
            Location loc = lm.getLastKnownLocation(LocationManager.NETWORK_PROVIDER);
            current_location_latitude = loc.getLatitude();
            current_location_longitutde = loc.getLongitude();
            //Toast.makeText(getApplicationContext(),current_location_latitude+" , "+ current_location_longitutde , Toast.LENGTH_SHORT).show();
        }
    }

    //-----------------Inner class to track --------------------------
    class BackgroundWorker_Location extends AsyncTask<String, String, String> {

        Context context;
        BackgroundWorker_Location (Context ctx) {
            context = ctx;
        }

        @Override
        protected String doInBackground(String... params) {

            String test_url = "http://172.20.10.2/rms2/API/track.php";

            try {
                URL url = new URL(test_url);
                HttpURLConnection httpURLConnection = (HttpURLConnection)url.openConnection();
                httpURLConnection.setRequestMethod("POST");
                httpURLConnection.setDoOutput(true);
                httpURLConnection.setDoInput(true);
                OutputStream outputStream = httpURLConnection.getOutputStream();
                BufferedWriter bufferedWriter = new BufferedWriter(new OutputStreamWriter(outputStream, "UTF-8"));
                String post_data = URLEncoder.encode("staff_id","UTF-8")+"="+URLEncoder.encode(staff_id,"UTF-8")+"&"
                        +URLEncoder.encode("latitude","UTF-8")+"="+URLEncoder.encode(current_location_latitude+"","UTF-8")+"&"
                        +URLEncoder.encode("longitude","UTF-8")+"="+URLEncoder.encode(current_location_longitutde+"","UTF-8");
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
            Toast.makeText(getApplicationContext(),result,Toast.LENGTH_SHORT).show();
        }


        @Override
        protected void onProgressUpdate(String... values) {
            super.onProgressUpdate(values);
        }
    } // ---------- inner class Ends here  -----------------

    //-----------------Inner class to fetch all Orders of user placed --------------------------
    class BackgroundWorker_Orders extends AsyncTask<String, String, String> {

        Context context;
        BackgroundWorker_Orders (Context ctx) {
            context = ctx;
        }

        @Override
        protected String doInBackground(String... params) {

            String test_url = "http://172.20.10.2/rms2/API/boy_orders.php";

            try {
                URL url = new URL(test_url);
                HttpURLConnection httpURLConnection = (HttpURLConnection)url.openConnection();
                httpURLConnection.setRequestMethod("POST");
                httpURLConnection.setDoOutput(true);
                httpURLConnection.setDoInput(true);
                OutputStream outputStream = httpURLConnection.getOutputStream();
                BufferedWriter bufferedWriter = new BufferedWriter(new OutputStreamWriter(outputStream, "UTF-8"));
                String post_data = URLEncoder.encode("staff_id","UTF-8")+"="+URLEncoder.encode(staff_id,"UTF-8");
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

            if (!result.equals("")) {
                try {
                    JSONArray orders = (new JSONObject(result)).getJSONArray("orders");
                    for (int i = 0; i < orders.length(); i++) {
                        //String cart_id = orders.getJSONObject(i).getString("cart_id");
                        String order_id = orders.getJSONObject(i).getString("order_id");
                        String food_name = orders.getJSONObject(i).getString("food_name");
                        String food_total = orders.getJSONObject(i).getString("total");
                        String street = orders.getJSONObject(i).getString("Street_Address");
                        String city = orders.getJSONObject(i).getString("City");
                        String mobile = orders.getJSONObject(i).getString("Mobile_No");
                        String delivered_flag = orders.getJSONObject(i).getString("delivered_flag");
                        String status= "";
                        if(delivered_flag.equals("0")){
                            status ="Not Delivered";
                        }
                        if(delivered_flag.equals("1")){
                            status ="Delivered";
                        }

                        orders_details.add("Item Name:"+food_name+"\nOrder Id:"+order_id+ "\nBill:Rs."+food_total+"\nStreet Address:"+street+"\nCity:"+city+"\nMobile No:"+mobile+"\nStatus:"+status);
                        orders_ids.add(order_id);
                        //staffs_ids.add(StaffID);
                        dataAdapter.notifyDataSetChanged();

                    }
                } catch (Exception e) {
                    e.printStackTrace();
                }

            }
        }

        @Override
        protected void onProgressUpdate(String... values) {
            super.onProgressUpdate(values);
        }
    } // ---------- inner class Ends here  -----------------

}
