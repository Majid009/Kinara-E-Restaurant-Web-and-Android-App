package com.example.majidm.sra;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.preference.PreferenceManager;
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

public class Orders extends AppCompatActivity {

    ListView listView ;
    TextView msg_txt ;
    List<String> orders_details = new ArrayList<String>();
    List<String> orders_ids = new ArrayList<String>();
    List<String> staffs_ids = new ArrayList<String>();
    ArrayAdapter<String> dataAdapter;
    String user_id , staff_id;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_orders);
        msg_txt = (TextView)findViewById(R.id.msg_txt);
        listView = (ListView)findViewById(R.id.orders_listView);
        dataAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, orders_details);
        listView.setAdapter(dataAdapter);

        listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {

            @Override
            public void onItemClick(AdapterView<?> parent, final View view, int position, long id) {
                staff_id = staffs_ids.get(position);
                if(staff_id.equals("0")){
                    Toast.makeText(getApplicationContext(),"wait...Delivery Boy is not allocated yet",Toast.LENGTH_SHORT).show();
                }
                if(!staff_id.equals("0")){
                    Toast.makeText(getApplicationContext(),"staff id: "+staff_id,Toast.LENGTH_SHORT).show();

                    Intent i = new Intent(getApplicationContext(), track.class);
                    i.putExtra("staff_id",staff_id );
                    startActivity(i);

                }
            }

        });

        //-------- Getting user id from session Data -----------
        SharedPreferences sharedPreferences = PreferenceManager.getDefaultSharedPreferences(getApplicationContext());
        user_id = sharedPreferences.getString("session_uid","0") ;

        BackgroundWorker_Orders backgroundWorker_orders = new BackgroundWorker_Orders(this);
        backgroundWorker_orders.execute();
    }  // --------------OnCreate Ends Here --------------

    //-----------------Inner class to fetch all Orders of user placed --------------------------
    class BackgroundWorker_Orders extends AsyncTask<String, String, String> {

        Context context;
        BackgroundWorker_Orders (Context ctx) {
            context = ctx;
        }

        @Override
        protected String doInBackground(String... params) {

            String test_url = "http://172.20.10.2/rms2/API/my_orders.php";

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
            if (result.equals("")){
                msg_txt.setText("You have not order anything...please try");
            }
            if (!result.equals("")) {
                try {
                    JSONArray orders = (new JSONObject(result)).getJSONArray("orders");
                    for (int i = 0; i < orders.length(); i++) {
                        String cart_id = orders.getJSONObject(i).getString("cart_id");
                        String order_id = orders.getJSONObject(i).getString("order_id");
                        String food_name = orders.getJSONObject(i).getString("food_name");
                        String food_total = orders.getJSONObject(i).getString("total");
                        String StaffID = orders.getJSONObject(i).getString("StaffID");
                        String status= "";
                        if(StaffID.equals("0")){
                            status ="Not";
                        }
                        if(!StaffID.equals("0")){
                            status ="Yes";
                        }

                        orders_details.add("Item Name:"+food_name+"\nOrder Id:"+order_id+ "\nBill:Rs."+food_total+"\nStatus:-\nDelivery boy Allocated:"+status+"\nDelivery boy Id:"+StaffID);
                        orders_ids.add(order_id);
                        staffs_ids.add(StaffID);
                        dataAdapter.notifyDataSetChanged();

                        msg_txt.setText("Note: Tap on order to track delivery boy");
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
