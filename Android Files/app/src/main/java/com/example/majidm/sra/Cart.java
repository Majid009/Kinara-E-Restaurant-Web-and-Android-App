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
import android.widget.Spinner;
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

public class Cart extends AppCompatActivity {

    ListView listView ;
    Spinner quantity_spinner , ids_spinner;
    TextView total_txt;
    List<String> cart_ids = new ArrayList<String>();
    List<String> cart_items = new ArrayList<String>();
    List<String> quantities_ids = new ArrayList<String>();
    List<String> quantities_values = new ArrayList<String>();
    ArrayAdapter<String> dataAdapter , dataAdapter2 ,dataAdapter3;
    int x = 0 ;
    String user_id , item_id , quantity_id ;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_cart);
        total_txt = (TextView)findViewById(R.id.total_txt);
        quantity_spinner = (Spinner)findViewById(R.id.quantity_spinner);
        ids_spinner = (Spinner)findViewById(R.id.ids_spinner);

        //-------- Getting user id from session Data -----------
        SharedPreferences sharedPreferences = PreferenceManager.getDefaultSharedPreferences(getApplicationContext());
        user_id = sharedPreferences.getString("session_uid","0") ;

        listView = (ListView)findViewById(R.id.cart_listView);
        dataAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, cart_items);
        listView.setAdapter(dataAdapter);

        listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {

            @Override
            public void onItemClick(AdapterView<?> parent, final View view, int position, long id) {
                item_id = cart_ids.get(position);
                AlertDialog.Builder builder = new AlertDialog.Builder(Cart.this);
                builder.setMessage("Do you want to order this item")
                        .setCancelable(false)
                        .setPositiveButton("Yes", new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                BackgroundWorker_Place_Order bg1 = new BackgroundWorker_Place_Order(getApplicationContext());
                                bg1.execute();
                                Intent i = new Intent(getApplicationContext(),Orders.class);
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

        //-----------------Spinner Related Code -----------------
        // Creating adapter for spinner
        dataAdapter2 = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, quantities_values);
        // Drop down layout style - list view with radio button
        dataAdapter2.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        // attaching data adapter to spinner
        quantity_spinner.setAdapter(dataAdapter2);

        quantity_spinner.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener(){
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                quantity_id = quantities_ids.get(position);

            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });

        //-----------------Spinner 2 Related Code -----------------
        // Creating adapter for spinner
        dataAdapter3 = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, cart_ids);
        // Drop down layout style - list view with radio button
        dataAdapter3.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        // attaching data adapter to spinner
        ids_spinner.setAdapter(dataAdapter3);

        ids_spinner.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener(){
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                item_id = cart_ids.get(position);
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });

        if(x==0){
            BackgroundWorker_get_quantities bg = new BackgroundWorker_get_quantities(this);
            bg.execute();

            BackgroundWorker_Cart bgworker = new BackgroundWorker_Cart(this);
            bgworker.execute();

        }
        x++;

    } //---------------------------OnCreate Ends Here --------------------------

    public void onUpdate(View v){
        BackgroundWorker_update_quantities bgw = new BackgroundWorker_update_quantities(this);
        bgw.execute();

        Intent i = new Intent(getApplicationContext(),Cart.class);
        startActivity(i);
    }


    //-----------------Inner class to fetch all Itmes in Cart --------------------------
    class BackgroundWorker_Cart extends AsyncTask<String, String, String> {

        Context context;
        BackgroundWorker_Cart (Context ctx) {
            context = ctx;
        }

        @Override
        protected String doInBackground(String... params) {

            String test_url = "http://172.20.10.2/rms2/API/cart.php";

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
                    JSONArray items = (new JSONObject(result)).getJSONArray("cart_items");
                    for (int i = 0; i < items.length(); i++) {
                        String cart_id = items.getJSONObject(i).getString("cart_id");
                        String food_name = items.getJSONObject(i).getString("food_name");
                        String food_price = items.getJSONObject(i).getString("food_price");
                        String food_quantity = items.getJSONObject(i).getString("quantity_value");
                        String food_total = items.getJSONObject(i).getString("total");
                        cart_items.add(food_name + "\nItem id:"+cart_id+"\n"+food_price + " x " + food_quantity + " = Rs." + food_total);
                        cart_ids.add(cart_id);
                        dataAdapter.notifyDataSetChanged();
                        dataAdapter3.notifyDataSetChanged();

                        String total_bill = (new JSONObject(result)).getString("total_bill");
                        total_txt.setText("Total: Rs. "+total_bill);

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

    //-----------------Inner class to fetch all quantities --------------------------
    class BackgroundWorker_get_quantities extends AsyncTask<String, String, String> {

        Context context;
        BackgroundWorker_get_quantities (Context ctx) {
            context = ctx;
        }

        @Override
        protected String doInBackground(String... params) {

            String test_url = "http://172.20.10.2/rms2/API/get_quantities.php";

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
                    JSONArray items = (new JSONObject(result)).getJSONArray("quantities");
                    for (int i = 0; i < items.length(); i++) {
                        String quantity_value = items.getJSONObject(i).getString("quantity_value");
                        String quantity_id = items.getJSONObject(i).getString("quantity_id");
                        quantities_ids.add(quantity_id);
                        quantities_values.add(quantity_value);
                        dataAdapter2.notifyDataSetChanged();
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

    //-----------------Inner class to fetch all quantities --------------------------
    class BackgroundWorker_update_quantities extends AsyncTask<String, String, String> {

        Context context;
        BackgroundWorker_update_quantities (Context ctx) {
            context = ctx;
        }

        @Override
        protected String doInBackground(String... params) {

            String test_url = "http://172.20.10.2/rms2/API/update-quantity.php";

            try {
                URL url = new URL(test_url);
                HttpURLConnection httpURLConnection = (HttpURLConnection)url.openConnection();
                httpURLConnection.setRequestMethod("POST");
                httpURLConnection.setDoOutput(true);
                httpURLConnection.setDoInput(true);
                OutputStream outputStream = httpURLConnection.getOutputStream();
                BufferedWriter bufferedWriter = new BufferedWriter(new OutputStreamWriter(outputStream, "UTF-8"));
                String post_data = URLEncoder.encode("user_id","UTF-8")+"="+URLEncoder.encode(user_id,"UTF-8")+"&"
                                   +URLEncoder.encode("item_id","UTF-8")+"="+URLEncoder.encode(item_id,"UTF-8")+"&"
                                   +URLEncoder.encode("quantity_id","UTF-8")+"="+URLEncoder.encode(quantity_id,"UTF-8");
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

    //-----------------Inner class to fetch all Itmes in Cart --------------------------
    class BackgroundWorker_Place_Order extends AsyncTask<String, String, String> {

        Context context;
        BackgroundWorker_Place_Order (Context ctx) {
            context = ctx;
        }

        @Override
        protected String doInBackground(String... params) {

            String test_url = "http://172.20.10.2/rms2/API/place_order.php";

            try {
                URL url = new URL(test_url);
                HttpURLConnection httpURLConnection = (HttpURLConnection)url.openConnection();
                httpURLConnection.setRequestMethod("POST");
                httpURLConnection.setDoOutput(true);
                httpURLConnection.setDoInput(true);
                OutputStream outputStream = httpURLConnection.getOutputStream();
                BufferedWriter bufferedWriter = new BufferedWriter(new OutputStreamWriter(outputStream, "UTF-8"));
                String post_data = URLEncoder.encode("user_id","UTF-8")+"="+URLEncoder.encode(user_id,"UTF-8")+"&"
                                      +URLEncoder.encode("cart_id","UTF-8")+"="+URLEncoder.encode(item_id,"UTF-8");
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
}
