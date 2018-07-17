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
import android.widget.EditText;
import android.widget.Spinner;
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

public class register extends AppCompatActivity {

    Spinner spinner ;
    ArrayAdapter<CharSequence> adapter ;

    EditText fname_txt , lname_txt , email_txt , pass_txt ,answer_txt ;
    String question_id;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);

        fname_txt = (EditText)findViewById(R.id.fname_f) ;
        lname_txt = (EditText)findViewById(R.id.lname_f) ;
        email_txt = (EditText)findViewById(R.id.email_f) ;
        pass_txt = (EditText)findViewById(R.id.password_f) ;
        answer_txt = (EditText)findViewById(R.id.answer_f);

        spinner = (Spinner)findViewById(R.id.question_spinner);
        adapter = ArrayAdapter.createFromResource(getApplicationContext(), R.array.spinnerItems, android.R.layout.simple_spinner_item);
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spinner.setAdapter(adapter);


        spinner.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener(){
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                question_id = (id+8)+"";
                //Toast.makeText(getApplicationContext(),question_id,Toast.LENGTH_SHORT).show();
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });
    }

    public void onRegister(View v){
        String fanme = fname_txt.getText().toString();
        String lname = lname_txt.getText().toString();
        String email = email_txt.getText().toString();
        String password = pass_txt.getText().toString();
        String answer = answer_txt.getText().toString();

        // ----- saving date for future use -----------
        SharedPreferences sharedPreferences = PreferenceManager.getDefaultSharedPreferences(getApplicationContext());
        SharedPreferences.Editor editor = sharedPreferences.edit();
        editor.putString("new_email", email);
        editor.commit();

        if(fanme.equals("") || lname.equals("") || email.equals("") || password.equals("") || answer.equals("") ){
            Toast.makeText(getApplicationContext(),"Fill All Feilds Properly",Toast.LENGTH_SHORT).show();
        }

        if(!fanme.equals("") && !lname.equals("") && !email.equals("") && !password.equals("") && !answer.equals("") ){
            BackgroundWorker_register bgworker = new BackgroundWorker_register(this);
            bgworker.execute(fanme,lname,email,password,question_id,answer);
        }



    }

}  //----------------------Main Class Ends Here -----------------------

class BackgroundWorker_register extends AsyncTask<String, String, String> {

    Context context;
    BackgroundWorker_register (Context ctx) {
        context = ctx;
    }

    @Override
    protected String doInBackground(String... params) {
        String fanme = params[0];
        String lname = params[1];
        String email = params[2];
        String password = params[3];
        String question_id = params[4];
        String answer = params[5];


        String test_url = "http://172.20.10.2/rms2/API/signup.php";

        try {
            URL url = new URL(test_url);
            HttpURLConnection httpURLConnection = (HttpURLConnection)url.openConnection();
            httpURLConnection.setRequestMethod("POST");
            httpURLConnection.setDoOutput(true);
            httpURLConnection.setDoInput(true);
            OutputStream outputStream = httpURLConnection.getOutputStream();
            BufferedWriter bufferedWriter = new BufferedWriter(new OutputStreamWriter(outputStream, "UTF-8"));
            String post_data = URLEncoder.encode("fname","UTF-8")+"="+URLEncoder.encode(fanme,"UTF-8")+"&"
                    +URLEncoder.encode("lname","UTF-8")+"="+URLEncoder.encode(lname,"UTF-8")+"&"
                    +URLEncoder.encode("email","UTF-8")+"="+URLEncoder.encode(email,"UTF-8")+"&"
                    +URLEncoder.encode("password","UTF-8")+"="+URLEncoder.encode(password,"UTF-8")+"&"
                    +URLEncoder.encode("question","UTF-8")+"="+URLEncoder.encode(question_id,"UTF-8")+"&"
                    +URLEncoder.encode("answer","UTF-8")+"="+URLEncoder.encode(answer,"UTF-8");
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
        String a = result ;
        if(a.equals("201")){
            Toast.makeText(context,"Your Account Created",Toast.LENGTH_SHORT).show();
            Intent i = new Intent(context,add_billing.class);
            context.startActivity(i);
        }
        if(a.equals("401")){
            Toast.makeText(context,"Email Already Exits",Toast.LENGTH_SHORT).show();
        }

        //super.onPostExecute(result);
    }

    @Override
    protected void onProgressUpdate(String... values) {
        super.onProgressUpdate(values);
    }
}


