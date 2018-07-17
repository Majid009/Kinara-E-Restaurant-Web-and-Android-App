package com.example.majidm.sra;

import android.content.Context;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.preference.PreferenceManager;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Spinner;
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

public class RateUs extends AppCompatActivity {

    Spinner foods_spinner , scales_spinner ;
    List<String> foods_ids = new ArrayList<String>();
    List<String> foods_names = new ArrayList<String>();
    List<String> scales_ids = new ArrayList<String>();
    List<String> scales_names = new ArrayList<String>();
    ArrayAdapter<String> dataAdapter ,dataAdapter2;
    int x = 0 ;
    String user_id , food_id , scale_id ;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_rate_us);

        //-------- Getting user id from session Data -----------
        SharedPreferences sharedPreferences = PreferenceManager.getDefaultSharedPreferences(getApplicationContext());
        user_id = sharedPreferences.getString("session_uid","0") ;

        //-----------------Food Spinner Related Code -----------------
        foods_spinner = (Spinner)findViewById(R.id.foods_spinner);
        // Creating adapter for spinner
        dataAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, foods_names);
        // Drop down layout style - list view with radio button
        dataAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        // attaching data adapter to spinner
        foods_spinner.setAdapter(dataAdapter);

        foods_spinner.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener(){
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                food_id = foods_ids.get(position);  //This will be food  id.
                //Toast.makeText(getApplicationContext(),food_id,Toast.LENGTH_SHORT).show();
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });

        //-----------------Scale Spinner Related Code -----------------
        scales_spinner = (Spinner)findViewById(R.id.scales_spinner);
        // Creating adapter for spinner
        dataAdapter2 = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, scales_names);
        // Drop down layout style - list view with radio button
        dataAdapter2.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        // attaching data adapter to spinner
        scales_spinner.setAdapter(dataAdapter2);

        scales_spinner.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener(){
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                scale_id = scales_ids.get(position);  //This will be scale  id.
                //Toast.makeText(getApplicationContext(),scale_id,Toast.LENGTH_SHORT).show();
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });

        if(x==0){
            BackgroundWorker_get_foods bgworker = new BackgroundWorker_get_foods(this);
            bgworker.execute();

            BackgroundWorker_get_scales bgworker2 = new BackgroundWorker_get_scales(this);
            bgworker2.execute();
        }

    } // -----------OnCreate Ebds Here----------------

    public void onPostRatings(View v){
      if(!user_id.equals("") && !food_id.equals("") && !scale_id.equals("")){
          BackgroundWorker_post_ratings bgworker3 = new BackgroundWorker_post_ratings(this);
          bgworker3.execute();
      }

    }

    //-----------------Inner class to fetch all Foods --------------------------
    class BackgroundWorker_get_foods extends AsyncTask<String, String, String> {

        Context context;
        BackgroundWorker_get_foods (Context ctx) {
            context = ctx;
        }

        @Override
        protected String doInBackground(String... params) {

            String test_url = "http://172.20.10.2/rms2/API/get_foods.php";

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

                JSONArray foods =(new JSONObject(result)).getJSONArray("foods");
                for (int i=0; i<foods.length(); i++){
                    String food_id = foods.getJSONObject(i).getString("food_id");
                    String food_name = foods.getJSONObject(i).getString("food_name");
                    foods_names.add(food_name);
                    foods_ids.add(food_id);
                    dataAdapter.notifyDataSetChanged();
                }

            }catch (Exception e) {e.printStackTrace();}

        }


        @Override
        protected void onProgressUpdate(String... values) {
            super.onProgressUpdate(values);
        }
    } // ---------- First inner class Ends here  -----------------

    //-----------------Inner class to fetch all scales --------------------------
    class BackgroundWorker_get_scales extends AsyncTask<String, String, String> {

        Context context;
        BackgroundWorker_get_scales (Context ctx) {
            context = ctx;
        }

        @Override
        protected String doInBackground(String... params) {

            String test_url = "http://172.20.10.2/rms2/API/get_scales.php";

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
                JSONArray scales =(new JSONObject(result)).getJSONArray("scales");
                for (int i=0; i<scales.length(); i++){
                    String scale_id = scales.getJSONObject(i).getString("rate_id");
                    String scale_name = scales.getJSONObject(i).getString("rate_name");
                    scales_names.add(scale_name);
                    scales_ids.add(scale_id);
                    dataAdapter2.notifyDataSetChanged();
                }

            }catch (Exception e) {e.printStackTrace();}

        }


        @Override
        protected void onProgressUpdate(String... values) {
            super.onProgressUpdate(values);
        }
    } // ---------- 2nd inner class Ends here  -----------------

    //-----------------Inner class to fetch all scales --------------------------
    class BackgroundWorker_post_ratings extends AsyncTask<String, String, String> {

        Context context;
        BackgroundWorker_post_ratings (Context ctx) {
            context = ctx;
        }

        @Override
        protected String doInBackground(String... params) {

            String test_url = "http://172.20.10.2/rms2/API/rateUs.php";

            try {
                URL url = new URL(test_url);
                HttpURLConnection httpURLConnection = (HttpURLConnection)url.openConnection();
                httpURLConnection.setRequestMethod("POST");
                httpURLConnection.setDoOutput(true);
                httpURLConnection.setDoInput(true);
                OutputStream outputStream = httpURLConnection.getOutputStream();
                BufferedWriter bufferedWriter = new BufferedWriter(new OutputStreamWriter(outputStream, "UTF-8"));
                String post_data = URLEncoder.encode("user_id","UTF-8")+"="+URLEncoder.encode(user_id,"UTF-8")+"&"
                        +URLEncoder.encode("food_id","UTF-8")+"="+URLEncoder.encode(food_id,"UTF-8")+"&"
                        +URLEncoder.encode("scale_id","UTF-8")+"="+URLEncoder.encode(scale_id,"UTF-8");
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
    } // ---------- 3nd inner class Ends here  -----------------
}
