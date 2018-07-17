package com.example.majidm.sra;

import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.preference.PreferenceManager;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
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

public class FoodZone extends AppCompatActivity {

    ListView listView ;
    List<String> foods_ids = new ArrayList<String>();
    List<String> foods_names = new ArrayList<String>();
    List<String> foods_prices = new ArrayList<String>();
    ArrayAdapter<String> dataAdapter ;
    int x = 0 ;
    String user_id , food_id , food_price ;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_food_zone);

        listView = (ListView)findViewById(R.id.foodzone_listView);

        //-------- Getting user id from session Data -----------
        SharedPreferences sharedPreferences = PreferenceManager.getDefaultSharedPreferences(getApplicationContext());
        user_id = sharedPreferences.getString("session_uid","0") ;

        dataAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, foods_names);

        listView.setAdapter(dataAdapter);

        listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {

            @Override
            public void onItemClick(AdapterView<?> parent, final View view, int position, long id) {
                food_id = foods_ids.get(position);
                food_price = foods_prices.get(position);
                AlertDialog.Builder builder = new AlertDialog.Builder(FoodZone.this);
                builder.setMessage("Do you want to Add to Cart this item")
                        .setCancelable(false)
                        .setPositiveButton("Yes", new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                BackgroundWorker_Cart_Exe  bgw = new BackgroundWorker_Cart_Exe(getApplicationContext());
                                bgw.execute();
                                Intent i = new Intent(getApplicationContext(),Cart.class);
                                startActivity(i);
                            }
                        })
                        .setNegativeButton("No", new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {

                            }
                        }) ;
                AlertDialog alertDialog = builder.create();
                alertDialog.setTitle("Alert !!!");
                alertDialog.show();
            }

        });

        if(x==0){
            BackgroundWorker_FoodZone bgworker = new BackgroundWorker_FoodZone(this);
            bgworker.execute();
        }
        x++;
    } //------------- Oncreate ends here -------------

    //-----------------Inner class to fetch Foods from Database --------------------------
    class BackgroundWorker_FoodZone extends AsyncTask<String, String, String> {

        Context context;
        BackgroundWorker_FoodZone (Context ctx) {
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
                String post_data = URLEncoder.encode("user_id","UTF-8")+"="+URLEncoder.encode(user_id,"UTF-8");
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
                    JSONArray items = (new JSONObject(result)).getJSONArray("foods");
                    for (int i = 0; i < items.length(); i++) {
                        String food_id = items.getJSONObject(i).getString("food_id");
                        String food_name = items.getJSONObject(i).getString("food_name");
                        String food_price = items.getJSONObject(i).getString("food_price");

                        foods_names.add(food_name + "\n" + "Rs."+food_price);
                        foods_ids.add(food_id);
                        foods_prices.add(food_price);
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

    //-----------------Inner class to Add to Cart --------------------------
    class BackgroundWorker_Cart_Exe extends AsyncTask<String, String, String> {

        Context context;
        BackgroundWorker_Cart_Exe (Context ctx) {
            context = ctx;
        }

        @Override
        protected String doInBackground(String... params) {

            String test_url = "http://172.20.10.2/rms2/API/addtocart.php";

            try {
                URL url = new URL(test_url);
                HttpURLConnection httpURLConnection = (HttpURLConnection)url.openConnection();
                httpURLConnection.setRequestMethod("POST");
                httpURLConnection.setDoOutput(true);
                httpURLConnection.setDoInput(true);
                OutputStream outputStream = httpURLConnection.getOutputStream();
                BufferedWriter bufferedWriter = new BufferedWriter(new OutputStreamWriter(outputStream, "UTF-8"));
                String post_data = URLEncoder.encode("user_id","UTF-8")+"="+URLEncoder.encode(user_id,"UTF-8")+"&"
                                   +URLEncoder.encode("food_id","UTF-8")+"="+URLEncoder.encode(food_id,"UTF-8");
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
    } // ---------- second inner class Ends here  -----------------
}
