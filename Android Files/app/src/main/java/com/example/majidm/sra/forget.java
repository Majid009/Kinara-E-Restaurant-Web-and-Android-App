package com.example.majidm.sra;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

public class forget extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_forget);
    }

    public void TestingFun(View v){
        for(int i=1 ; i<5 ; i++){
            
            //Toast.makeText(getApplicationContext(),i+"",Toast.LENGTH_SHORT).show();
        }

    }
}
