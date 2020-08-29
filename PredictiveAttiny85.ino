#include <SendOnlySoftwareSerial.h>
#include <TinyWireM.h>
#include <OneWire.h>
#include <GY21.h>
#define Hall    A2
#define TX    3
SendOnlySoftwareSerial Serial2(TX);
#define ONEWIRE_BUSS 1
OneWire TemperatureSensor(ONEWIRE_BUSS);

GY21 sensor;

const int MPU_addr = 0x68;
int16_t AcX, AcY, AcZ, Tmp, GyX, GyY, GyZ, hallval;
int8_t MotorTemp, hallVal;
int8_t AmbiantTemp, AmbiantH;
void setup() {
  Serial2.begin(9600);
  delay(8000);
  Serial2.println("1");
  TinyWireM.begin();
  TinyWireM.beginTransmission(MPU_addr);
  TinyWireM.write(0x6B);  
  TinyWireM.write(0);    
  TinyWireM.endTransmission(true);

}
void loop() {

  //hall
  
  hallVal = analogRead(Hall);
  hallVal = map(hallVal, 0, 1023, -100, 60);


  //SHT21
  AmbiantTemp = abs(sensor.GY21_Temperature());
  AmbiantH = abs(sensor.GY21_Humidity());


  //MPU6050
  TinyWireM.beginTransmission(MPU_addr);
  TinyWireM.write(0x3B);  
  TinyWireM.endTransmission(false);
  TinyWireM.requestFrom(MPU_addr, 14); // demander 14 registres
  AcX = TinyWireM.read() << 8 | TinyWireM.read();  
  AcY = TinyWireM.read() << 8 | TinyWireM.read();
  AcZ = TinyWireM.read() << 8 | TinyWireM.read();
  Tmp = TinyWireM.read() << 8 | TinyWireM.read();
  GyX = TinyWireM.read() << 8 | TinyWireM.read();
  GyY = TinyWireM.read() << 8 | TinyWireM.read();
  GyZ = TinyWireM.read() << 8 | TinyWireM.read();
  delay(100);





  //18B20


  MotorTemp = ds18b20();


  //Send all

  Serial2.print("device_id=1&");
  Serial2.print("HallVal=");
  Serial2.print(hallVal);
  Serial2.print("&AmbiantTemp=");
  Serial2.print(AmbiantTemp);
  Serial2.print("&AmbiantH=");
  Serial2.print(AmbiantH);
  Serial2.print("&AcX=");
  Serial2.print(AcX);
  Serial2.print("&AcY=");
  Serial2.print(AcY);
  Serial2.print("&AcZ=");
  Serial2.print(AcZ);
  Serial2.print("&Tmp=");
  Serial2.print(Tmp);
  Serial2.print("&GyX=");
  Serial2.print(GyX);
  Serial2.print("&GyY=");
  Serial2.print(GyY);
  Serial2.print("&GyZ=");
  Serial2.print(GyZ);
  Serial2.print("&MotorTemp=");
  Serial2.print(MotorTemp);
  Serial2.println();


  delay(10000);
}


float ds18b20() {
  byte i;
  byte data[12];
  int16_t raw;
  float t;
  TemperatureSensor.reset(); 
  TemperatureSensor.skip();

  TemperatureSensor.write(0x44);

  delay(1000);

  TemperatureSensor.reset();
  TemperatureSensor.skip();

  TemperatureSensor.write(0xBE);

  for ( i = 0; i < 9; i++) {

    data[i] = TemperatureSensor.read();

  }

  raw = (data[1] << 8) | data[0];
  t = (float)raw / 16.0;
  return (t);
}


