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

public class reservations extends AppCompatActivity {

    ListView tables_list , rooms_list ;
    TextView table_title , room_title ;
    List<String> tables_reservation_details = new ArrayList<String>();
    List<String> tables_reservation_ids = new ArrayList<String>();
    List<String> rooms_reservation_details = new ArrayList<String>();
    List<String> rooms_reservation_ids = new ArrayList<String>();
    ArrayAdapter<String> dataAdapter_tables;
    ArrayAdapter<String> dataAdapter_rooms;
    String user_id , reservation_id;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_reservations);

        // --------------Initialising all componenets ----------------------
        table_title = (TextView)findViewById(R.id.table_title);
        room_title = (TextView)findViewById(R.id.room_title);
        tables_list = (ListView)findViewById(R.id.tables_list);
        rooms_list = (ListView)findViewById(R.id.rooms_list);

        //-------- Getting user id from session Data -----------
        SharedPreferences sharedPreferences = PreferenceManager.getDefaultSharedPreferences(getApplicationContext());
        user_id = sharedPreferences.getString("session_uid","0") ;

        dataAdapter_tables = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, tables_reservation_details);
        tables_list.setAdapter(dataAdapter_tables);
        tables_list.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, final View view, int position, long id) {
               // Toast.makeText(getApplicationContext(),tables_reservation_ids.get(position),Toast.LENGTH_SHORT).show();
                reservation_id = tables_reservation_ids.get(position);
                AlertDialog.Builder builder = new AlertDialog.Builder(reservations.this);
                builder.setMessage("Do you want to cancel your Reservation")
                        .setCancelable(false)
                        .setPositiveButton("Yes", new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                BackgroundWorker_cancel bg = new BackgroundWorker_cancel(getApplicationContext());
                                bg.execute();
                                Intent i = new Intent(getApplicationContext(),reservations.class);
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

        dataAdapter_rooms = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, rooms_reservation_details);
        rooms_list.setAdapter(dataAdapter_rooms);
        rooms_list.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, final View view, int position, long id) {
                reservation_id = rooms_reservation_ids.get(position);
                AlertDialog.Builder builder = new AlertDialog.Builder(reservations.this);
                builder.setMessage("Do you want to cancel your Reservation")
                        .setCancelable(false)
                        .setPositiveButton("Yes", new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                BackgroundWorker_cancel bg = new BackgroundWorker_cancel(getApplicationContext());
                                bg.execute();
                                Intent i = new Intent(getApplicationContext(),reservations.class);
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

        BackgroundWorker_Tables bg = new BackgroundWorker_Tables(getApplicationContext());
        bg.execute();

        BackgroundWorker_Rooms bg2 = new BackgroundWorker_Rooms(getApplicationContext());
        bg2.execute();

    }  //------------------- On create ends here ------------------

    //-----------------Inner class to fetch all Tables --------------------------
    class BackgroundWorker_Tables extends AsyncTask<String, String, String> {

        Context context;
        BackgroundWorker_Tables (Context ctx) {
            context = ctx;
        }

        @Override
        protected String doInBackground(String... params) {

            String test_url = "http://172.20.10.2/rms2/API/my_tables.php";

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
            try{
                JSONArray tables =(new JSONObject(result)).getJSONArray("my_tables");
                for (int i=0; i<tables.length(); i++){
                    String reservation_id = tables.getJSONObject(i).getString("ReservationID");
                    String table_name = tables.getJSONObject(i).getString("table_name");
                    String date = tables.getJSONObject(i).getString("Reserve_Date");
                    String time = tables.getJSONObject(i).getString("Reserve_Time");
                    tables_reservation_details.add(table_name +"     "+date+"      "+time);
                    tables_reservation_ids.add(reservation_id);
                    dataAdapter_tables.notifyDataSetChanged();
                    table_title.setText("   Table #         Date            Time");
                }
            }catch (Exception e) {e.printStackTrace();}

        }


        @Override
        protected void onProgressUpdate(String... values) {
            super.onProgressUpdate(values);
        }
    } // ---------- First inner class Ends here  -----------------

    //-----------------Inner class to fetch all Rooms --------------------------
    class BackgroundWorker_Rooms extends AsyncTask<String, String, String> {

        Context context;
        BackgroundWorker_Rooms (Context ctx) {
            context = ctx;
        }

        @Override
        protected String doInBackground(String... params) {

            String test_url = "http://172.20.10.2/rms2/API/my_rooms.php";

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
            try{
                JSONArray rooms =(new JSONObject(result)).getJSONArray("my_rooms");
                for (int i=0; i<rooms.length(); i++){
                    String reservation_id = rooms.getJSONObject(i).getString("ReservationID");
                    String room_name = rooms.getJSONObject(i).getString("partyhall_name");
                    String date = rooms.getJSONObject(i).getString("Reserve_Date");
                    String time = rooms.getJSONObject(i).getString("Reserve_Time");
                    rooms_reservation_details.add(room_name +"      "+date+"       "+time);
                    rooms_reservation_ids.add(reservation_id);
                    dataAdapter_rooms.notifyDataSetChanged();
                    room_title.setText("   Room #          Date           Time");
                }
            }catch (Exception e) {e.printStackTrace();}

        }


        @Override
        protected void onProgressUpdate(String... values) {
            super.onProgressUpdate(values);
        }
    } // ---------- second inner class Ends here  -----------------

    //-----------------Inner class to cancel reservation --------------------------
    class BackgroundWorker_cancel extends AsyncTask<String, String, String> {

        Context context;
        BackgroundWorker_cancel (Context ctx) {
            context = ctx;
        }

        @Override
        protected String doInBackground(String... params) {

            String test_url = "http://172.20.10.2/rms2/API/cancel_reservation.php";

            try {
                URL url = new URL(test_url);
                HttpURLConnection httpURLConnection = (HttpURLConnection)url.openConnection();
                httpURLConnection.setRequestMethod("POST");
                httpURLConnection.setDoOutput(true);
                httpURLConnection.setDoInput(true);
                OutputStream outputStream = httpURLConnection.getOutputStream();
                BufferedWriter bufferedWriter = new BufferedWriter(new OutputStreamWriter(outputStream, "UTF-8"));
                String post_data = URLEncoder.encode("reservation_id","UTF-8")+"="+URLEncoder.encode(reservation_id,"UTF-8");
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
    } // ---------- 3rd inner class Ends here  -----------------
}
