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

public class login extends AppCompatActivity {

    EditText email_feild , password_feild ;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        email_feild = (EditText)findViewById(R.id.email_feild);
        password_feild = (EditText)findViewById(R.id.password_feild);
    }

    public void onLogin(View v){
       String email = email_feild.getText().toString();
        String password = password_feild.getText().toString();
        if(email.equals("") || password.equals("")){
            Toast.makeText(getApplicationContext(),"Fill All Feilds Properly",Toast.LENGTH_SHORT).show();
        }
         if(!email.equals("") && !password.equals("")) {
             BackgroundWorker_login bgworker = new BackgroundWorker_login(this);
             bgworker.execute(email, password);
         }


    }


//    public void onForget(View v)
//    {
//        Intent i = new Intent(this,forget.class);
//        startActivity(i);
//    }
}  //----------------------Mail Class Ends Here

class BackgroundWorker_login extends AsyncTask<String, String, String> {
    Context context;
    BackgroundWorker_login (Context ctx) {
        context = ctx;
    }

    @Override
    protected String doInBackground(String... params) {
        String email = params[0];
        String password = params[1];

        String test_url = "http://172.20.10.2/rms2/API/login.php";

        try {
            URL url = new URL(test_url);
            HttpURLConnection httpURLConnection = (HttpURLConnection)url.openConnection();
            httpURLConnection.setRequestMethod("POST");
            httpURLConnection.setDoOutput(true);
            httpURLConnection.setDoInput(true);
            OutputStream outputStream = httpURLConnection.getOutputStream();
            BufferedWriter bufferedWriter = new BufferedWriter(new OutputStreamWriter(outputStream, "UTF-8"));
            String post_data = URLEncoder.encode("email","UTF-8")+"="+URLEncoder.encode(email,"UTF-8")+"&"
                    +URLEncoder.encode("password","UTF-8")+"="+URLEncoder.encode(password,"UTF-8");
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
        String response = result;
        if(response.contains("200")){
            String[] a = response.split(",");  // Parsing of respose

            // ----- saving date for future use -----------
            SharedPreferences sharedPreferences = PreferenceManager.getDefaultSharedPreferences(context);
            SharedPreferences.Editor editor = sharedPreferences.edit();
            editor.putString("session_uid", a[1]);
            editor.putString("session_fname", a[2]);
            editor.putString("session_lname", a[3]);
            editor.commit();

            Toast.makeText(context,"Login Successfull",Toast.LENGTH_SHORT).show();
            Intent i = new Intent(context,Main_Menu.class);
            context.startActivity(i);
        }
        if(response.equals("400")){
            Toast.makeText(context,"Login Failed",Toast.LENGTH_SHORT).show();
        }
    }



    @Override
    protected void onProgressUpdate(String... values) {
        super.onProgressUpdate(values);
    }
}
