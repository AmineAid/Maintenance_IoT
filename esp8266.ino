#include <Arduino.h>
#include <ESP8266WiFi.h>
#include <ESP8266WiFiMulti.h>
#include <ESP8266HTTPClient.h>
#define USE_SERIAL Serial
ESP8266WiFiMulti WiFiMulti;

const char* ssid = "ciscosb-1";
const char* password = "MotDePasse@";

void setup() {
  delay(6000);
  Serial.begin(9600);
  Serial.println();
  Serial.print("connecting to ");
  Serial.println(ssid);
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.println("WiFi connected");
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());
}
int endoffile=0;


void loop() {
 if (USE_SERIAL.available()) {
    String c = USE_SERIAL.readString();
    USE_SERIAL.println(c);
    if(c.indexOf("device")>=0){
      transferdata(c);
}
}
}
int length,httpCode;
String payload,link;
void transferdata(String data){
  

  if ((WiFiMulti.run() == WL_CONNECTED)) {
    HTTPClient http;
     link="http://192.168.1.200/RD/Predictive27/log.php?";
    link+=data;
    length = link.length()-3;
    link.remove(length, 3);
    http.begin(link); 
    httpCode = http.GET();
    if (httpCode > 0) {
      if (httpCode == HTTP_CODE_OK) {
        payload = http.getString();
        USE_SERIAL.println(payload);
      }
    } else {
      USE_SERIAL.println("error b2");
    }

    http.end();
  }
  
  }



