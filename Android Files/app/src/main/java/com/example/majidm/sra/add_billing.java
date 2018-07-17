package com.example.majidm.sra;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.preference.PreferenceManager;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

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

public class add_billing extends AppCompatActivity {
  String email , street , city , mobile , landline , pobox;
    EditText street_txt , city_txt , mobile_txt , landline_txt ,pobox_txt ;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_add_billing);

        street_txt = (EditText) findViewById(R.id.street_address);
        city_txt = (EditText) findViewById(R.id.city);
        mobile_txt =(EditText)findViewById(R.id.moblie_no) ;
        landline_txt =(EditText)findViewById(R.id.landline_no);
        pobox_txt = (EditText)findViewById(R.id.po_box_no);

        //-------- Getting user id from session Data -----------
        SharedPreferences sharedPreferences = PreferenceManager.getDefaultSharedPreferences(getApplicationContext());
        email = sharedPreferences.getString("new_email","0") ;
    }

    public void onAdd(View v){
        street = street_txt.getText().toString();
        city = city_txt.getText().toString();
        mobile = mobile_txt.getText().toString();
        landline = landline_txt.getText().toString();
        pobox = pobox_txt.getText().toString();

        if(street.equals("") || city.equals("") || mobile.equals("") || landline.equals("") || pobox.equals("")){
            Toast.makeText(getApplicationContext(),"Fill All Feilds Properly",Toast.LENGTH_SHORT).show();
        }

        if(!street.equals("") && !city.equals("") && !mobile.equals("") && !landline.equals("") && !pobox.equals("")){
            BackgroundWorker_Add_Billing bgw = new BackgroundWorker_Add_Billing(getApplicationContext());
            bgw.execute();
        }

    }

    //-----------------Inner class to Add_Billing --------------------------
    class BackgroundWorker_Add_Billing extends AsyncTask<String, String, String> {

        Context context;
        BackgroundWorker_Add_Billing (Context ctx) {
            context = ctx;
        }

        @Override
        protected String doInBackground(String... params) {

            String test_url = "http://172.20.10.2/rms2/API/add_billing.php";

            try {
                URL url = new URL(test_url);
                HttpURLConnection httpURLConnection = (HttpURLConnection)url.openConnection();
                httpURLConnection.setRequestMethod("POST");
                httpURLConnection.setDoOutput(true);
                httpURLConnection.setDoInput(true);
                OutputStream outputStream = httpURLConnection.getOutputStream();
                BufferedWriter bufferedWriter = new BufferedWriter(new OutputStreamWriter(outputStream, "UTF-8"));
                String post_data = URLEncoder.encode("email","UTF-8")+"="+URLEncoder.encode(email,"UTF-8")+"&"
                        +URLEncoder.encode("street","UTF-8")+"="+URLEncoder.encode(street,"UTF-8")+"&"
                        +URLEncoder.encode("city","UTF-8")+"="+URLEncoder.encode(city,"UTF-8")+"&"
                        +URLEncoder.encode("mobile","UTF-8")+"="+URLEncoder.encode(mobile,"UTF-8")+"&"
                        +URLEncoder.encode("landline","UTF-8")+"="+URLEncoder.encode(landline,"UTF-8")+"&"
                        +URLEncoder.encode("pobox","UTF-8")+"="+URLEncoder.encode(pobox,"UTF-8")+"&";
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
            Intent i = new Intent(context , Wellcome.class);
            startActivity(i);
        }

        @Override
        protected void onProgressUpdate(String... values) {
            super.onProgressUpdate(values);
        }
    } // ---------- first inner class Ends here  -----------------

}
