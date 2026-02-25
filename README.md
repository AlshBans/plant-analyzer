#  Smart Indoor Cultivation System  
### AI + IoT + Computer Network Integrated Framework

---

##  Project Overview

The Smart Indoor Cultivation System is an integrated AI–IoT–Computer Network (CN) based framework designed to automate and optimize indoor plant growth.  
It continuously monitors environmental conditions, analyzes plant health using AI, and ensures reliable communication through network-based data transmission.

This project demonstrates how Artificial Intelligence, Internet of Things (IoT), and Computer Networks can work together to create an intelligent, energy-efficient, and scalable indoor farming solution.

---

##  Key Features

-  Real-time Temperature & Humidity Monitoring (DHT11)
-  Soil Moisture Monitoring
-  Adaptive LED Lighting Control
-  Relay-based Automated Switching
-  Real-time Web Dashboard (JSON Communication)
-  AI-based Plant Health Analyzer
-  Network Performance Monitoring (RSSI, RTT, Packet Loss)
-  Energy-efficient Automation (~35% power savings)
-  System Uptime > 99%

---

##  System Architecture

### Hardware Components
- NodeMCU ESP8266
- DHT11 Sensor
- Soil Moisture Sensor
- LDR (Light Sensor)
- 2-Channel Relay Module
- LED Grow Light
- Power Supply

### Software Components
- Arduino IDE (Embedded Programming)
- Wi-Fi Communication (HTTP Protocol)
- JSON Data Transmission
- Local/Cloud Dashboard
- AI Model for Plant Health Analysis

---

##  Working Principle

1. IoT sensors collect real-time environmental data.
2. NodeMCU processes and transmits data via Wi-Fi.
3. Data is sent to a server/dashboard using HTTP JSON format.
4. AI model analyzes plant images and sensor data.
5. Automated feedback loop adjusts lighting and irrigation.
6. Network metrics (RSSI, latency, uptime) ensure communication reliability.

---

##  Computer Network Integration

The system measures:
- Signal Strength (RSSI)
- Round Trip Time (RTT)
- Packet Transmission Success
- System Uptime

This validates real-time IoT communication reliability and ensures continuous operation.

---

##  Experimental Results

-  35% reduction in energy consumption using adaptive lighting
-  Stable Wi-Fi communication with minimal packet loss
-  System uptime maintained above 99%
-  Improved environmental regulation accuracy

---


