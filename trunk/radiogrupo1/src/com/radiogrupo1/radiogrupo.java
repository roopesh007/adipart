package com.radiogrupo1;

import java.io.IOException;

import com.radiogrupo1.R;

import android.app.Activity;
import android.app.Dialog;
import android.media.MediaPlayer;
import android.os.Bundle;
import android.view.MenuItem;
import android.view.MotionEvent;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;
import android.widget.AdapterView.OnItemSelectedListener;
import android.view.View.OnClickListener;



public class radiogrupo extends Activity {
    /** Called when the activity is first created. */
	

	
	MediaPlayer mediaPlayer;
	Button buttonPlayPause, buttonQuit, buttonStop;
	TextView textState, stationSelect;
	
	private int stateMediaPlayer;
	private final int stateMP_Error = 0;
	private final int stateMP_NotStarter = 1;
	private final int stateMP_Playing = 2;
	private final int stateMP_Pausing = 3;
	private final int stateMP_Stopping = 4;
	private final int initMode = 5;
	private final int stateMP_NotSelected = 6 ;
    private Dialog dialog;

	
    @Override
    public void onCreate(Bundle savedInstanceState) {

    	super.onCreate(savedInstanceState);
        setContentView(R.layout.main);
              
        Spinner spinner = (Spinner) findViewById(R.id.spinner);
        ArrayAdapter<CharSequence> adapter = ArrayAdapter.createFromResource(
                this, R.array.station_array, android.R.layout.simple_spinner_item);
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spinner.setAdapter(adapter);
        
        
    	buttonPlayPause = (Button)findViewById(R.id.playpause);
    	buttonStop = (Button)findViewById(R.id.stop);
        buttonQuit = (Button)findViewById(R.id.quit);
        textState = (TextView)findViewById(R.id.state);
        stationSelect = (TextView)findViewById(R.id.selected_station);
        
        buttonPlayPause.setOnClickListener(buttonPlayPauseOnClickListener);
        buttonStop.setOnClickListener(buttonOnStop);
        buttonQuit.setOnClickListener(buttonQuitOnClickListener);
       
		stateMediaPlayer = initMode;
        
		buttonPlayPause.setOnTouchListener(buttonPlayPauseOnTouchListener);
		
        spinner.setOnItemSelectedListener(new MyOnItemSelectedListener());
        
    }
    

    
    
    public static class Global {
    	static int StationIndex;
    	static String StationName;
    	
    }
    
    public class MyOnItemSelectedListener implements OnItemSelectedListener {

        public void onItemSelected(AdapterView<?> parent,
            View view, int pos, long id) {
          Global.StationName=parent.getItemAtPosition(pos).toString();
          Global.StationIndex = pos;
		  if (pos > 0) {
		    if (stateMediaPlayer == stateMP_Playing) {
			  mediaPlayer.stop();
			  mediaPlayer.release();
			  buttonPlayPause.setText("Play");
		    }
		    stateMediaPlayer = stateMP_NotStarter;
		    Toast.makeText(parent.getContext(), "La Estación Selecionada es: " +
		      Global.StationName, Toast.LENGTH_LONG).show();
		    setImageStation();
		  }
		  else
			stateMediaPlayer = stateMP_NotSelected;


        }

        public void onNothingSelected(AdapterView<?> parent) {
        	
        	// Do nothing.
        }
    }
    
    private void setImageStation()
    {
    	
    	  int resid = 0;
    	  switch (Global.StationIndex) {
    	  
	   	  case 1: resid = R.drawable.magia101;break;
	  	  case 2: resid = R.drawable.lapoderosa;break;
	  	  case 3: resid = R.drawable.radiobi;break;
	  	  case 4: resid = R.drawable.digital;break;
	  	  case 5: resid = R.drawable.larancherita;break;
	  	  default: 	textState.setText("Primero Seleciona la Estación" );break;
    }    
    	  ImageView radiogrupoImage = (ImageView) findViewById(R.id.ImageView02);
    	  radiogrupoImage.setBackgroundResource(resid);
    } 
    
    
    private void initMediaPlayer()
    {
    	
    	String PATH_TO_FILE = null;
    	boolean ready = true;
    	
    	switch (Global.StationIndex) {
    	  
     	  case 1: PATH_TO_FILE = "http://201.151.158.7:88/broadwave.mp3?src=1&kbps=64";break;
    	  case 2: PATH_TO_FILE = "http://201.151.158.7:88/broadwave.mp3?src=2&kbps=64";break;
    	  case 3: PATH_TO_FILE = "http://201.151.158.7:88/broadwave.mp3?src=3&kbps=64";break;
    	  case 4: PATH_TO_FILE = "http://201.151.158.6:88/broadwave.mp3?src=1&kbps=64";break;
    	  case 5: PATH_TO_FILE = "http://201.151.158.5:88/broadwave.mp3?src=1&kbps=64";break;
    	  default: 	ready=false; textState.setText("Primero Seleciona la Estación" );break;
    	} 

   if (ready) {
    	mediaPlayer = new  MediaPlayer();
    	
    	
    	try {
			mediaPlayer.setDataSource(PATH_TO_FILE);
			mediaPlayer.prepare();
			//Toast.makeText(this, PATH_TO_FILE, Toast.LENGTH_LONG).show();
			stateMediaPlayer = stateMP_NotStarter;
	        textState.setText("- Conexión Exitosa -");
		} catch (IllegalArgumentException e) {
			e.printStackTrace();
//			Toast.makeText(this, e.toString(), Toast.LENGTH_LONG).show();
			stateMediaPlayer = stateMP_Error;
	        textState.setText("- ERROR!!! -");
		} catch (IllegalStateException e) {
			e.printStackTrace();
//			Toast.makeText(this, e.toString(), Toast.LENGTH_LONG).show();
			stateMediaPlayer = stateMP_Error;
	        textState.setText("- ERROR!!! -");
		} catch (IOException e) {
			
			e.printStackTrace();
//			Toast.makeText(this, e.toString(), Toast.LENGTH_LONG).show();
			stateMediaPlayer = stateMP_Error;
	        textState.setText("- ERROR!!! -");
		} //try
    } // ready
    } // void
    
    Button.OnClickListener buttonPlayPauseOnClickListener
	= new Button.OnClickListener(){

		public void onClick(View v) {
			
			switch(stateMediaPlayer){
			case stateMP_Error:
				break;
			case initMode:
				stationSelect.setText("Oh, Por favor Primero Selecciona la Estación ");
				break;
			case stateMP_NotStarter:
				initMediaPlayer();	
				mediaPlayer.start();
				buttonPlayPause.setText("Pause");
				textState.setText("- Online - " + Global.StationName );
				stateMediaPlayer = stateMP_Playing;
				break;
			case stateMP_Stopping:
				initMediaPlayer();
				mediaPlayer.start();
				buttonPlayPause.setText("Pause");
				textState.setText("- Online - " + Global.StationName);
				stateMediaPlayer = stateMP_Playing;
				break;
			case stateMP_Playing:
				mediaPlayer.pause();
				buttonPlayPause.setText("Play");
				textState.setText("- PAUSING -");
				stateMediaPlayer = stateMP_Pausing;
				break;
		    case stateMP_Pausing:
				mediaPlayer.start();
				buttonPlayPause.setText("Pause");
				textState.setText("- Online - " + Global.StationName);
				stateMediaPlayer = stateMP_Playing;
				break;
				
		    case stateMP_NotSelected:
				textState.setText(" Primero Seleciona la Estación " ); 
				break;
		    	
			}
			
		}
};
    

Button.OnTouchListener buttonPlayPauseOnTouchListener
= new Button.OnTouchListener(){
    
    public boolean onTouch(View v, MotionEvent ACTION_DOWN) {
    	textState.setText("- Realizando la Conexión -");
        return false;
    }

    };



Button.OnClickListener buttonOnStop
= new Button.OnClickListener(){

	public void onClick(View v) {
	switch(stateMediaPlayer){
	case stateMP_Playing:
		buttonPlayPause.setText("Play");
		textState.setText("- Stop -");
		stateMediaPlayer = stateMP_Stopping;
		mediaPlayer.stop();
		mediaPlayer.reset();
	    break;
	}
    }
};
	
Button.OnClickListener buttonQuitOnClickListener
= new Button.OnClickListener(){

	public void onClick(View v) {
		switch (stateMediaPlayer) {
		case stateMP_NotStarter: break;
		case stateMP_Playing:
			buttonPlayPause.setText("Play");
			textState.setText("- STOPPING -");
			stateMediaPlayer = stateMP_Stopping;
			mediaPlayer.stop();
			mediaPlayer.release();
		    break;
		case initMode: break;
		default: break;
		}
	finish();
	}	
};

    
    public boolean onCreateOptionsMenu(android.view.Menu menu)
    {
        super.onCreateOptionsMenu(menu);
        /* Add os menus */
        menu.add(0, R.layout.dialogo  , 0, "design & development");
        menu.add(0, R.id.quit       , 0, "Salir");
        return true;
        
    }
    
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
        case R.id.quit:
        switch (stateMediaPlayer) {
        case stateMP_NotStarter: break;
        case stateMP_Playing:
             buttonPlayPause.setText("Play");
             textState.setText("- STOPPING -");
             stateMediaPlayer = stateMP_Stopping;
             mediaPlayer.stop();
             mediaPlayer.release();
             break;
                    case initMode: break;
                    default: break;}
                    finish();
    		
			
	    case R.layout.dialogo:    
	    	dialog = new Dialog(radiogrupo.this);
            dialog.setContentView(R.layout.dialogo);
            dialog.setTitle(radiogrupo.this.getString(R.string.app_name));
            dialog.setCancelable(true);

            Button closeDialog = (Button) dialog.findViewById(R.id.closeDialog);
            closeDialog.setOnClickListener(new OnClickListener() {
                public void onClick(View v) {
                    dialog.dismiss();
                }
            });
            dialog.show();
	        return true;     
	    }   
	    return false; //should never happen  
	}  
 
    
    
}