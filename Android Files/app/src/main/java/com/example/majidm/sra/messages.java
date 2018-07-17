package com.example.majidm.sra;

import android.content.Context;
import android.content.Intent;
import android.os.AsyncTask;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListView;
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

public class messages extends AppCompatActivity {

    ListView messages_listview ;
    List<String> messages_details = new ArrayList<String>();
    ArrayAdapter<String> dataAdapter;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_messages);

        messages_listview = (ListView)findViewById(R.id.messages_listView);
        dataAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, messages_details);
        messages_listview.setAdapter(dataAdapter);

        BackgroundWorker_Messages backgroundWorker_orders = new BackgroundWorker_Messages(this);
        backgroundWorker_orders.execute();

    }

    //-----------------Inner class to fetch all Messages --------------------------
    class BackgroundWorker_Messages extends AsyncTask<String, String, String> {

        Context context;
        BackgroundWorker_Messages (Context ctx) {
            context = ctx;
        }

        @Override
        protected String doInBackground(String... params) {

            String test_url = "http://172.20.10.2/rms2/API/messages.php";

            try {
                URL url = new URL(test_url);
                HttpURLConnection httpURLConnection = (HttpURLConnection)url.openConnection();
                httpURLConnection.setRequestMethod("POST");
                httpURLConnection.setDoOutput(true);
                httpURLConnection.setDoInput(true);
                OutputStream outputStream = httpURLConnection.getOutputStream();
                BufferedWriter bufferedWriter = new BufferedWriter(new OutputStreamWriter(outputStream, "UTF-8"));
                String post_data = URLEncoder.encode("a","UTF-8")+"="+URLEncoder.encode("","UTF-8");
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

            }
            if (!result.equals("")) {
                try {
                    JSONArray messages = (new JSONObject(result)).getJSONArray("messages");
                    for (int i = 0; i < messages.length(); i++) {
                        String m_from = messages.getJSONObject(i).getString("message_from");
                        String m_time = messages.getJSONObject(i).getString("message_time");
                        String m_date = messages.getJSONObject(i).getString("message_date");
                        String m_subject = messages.getJSONObject(i).getString("message_subject");
                        String m_txt = messages.getJSONObject(i).getString("message_text");
                        messages_details.add("Message Time:"+m_time+"\nMessage Date:"+m_date+"\nFrom:"+m_from+"\nSubject:"+m_subject+"\nMessage:-\n"+m_txt);
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
