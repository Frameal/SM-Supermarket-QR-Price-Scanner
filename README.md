# SM-Supermarket-QR-Price-Scanner
A really simple QR Code scanning system simulating SM Supermarket's price checker system. 


------------------------------


# Overview
This project is an activity for our Server Administration Management (SERADM) subject. It demonstrates a really simple QR code scanning system connected to a MySQL database without detailed error handling.

This system is to be integrated into a virtual server and client environment using Oracle VirtualBox as a Web Server (IIS) for the final activity of the subject.

The system consists of these main modules:

1. Client Scanner Interface (Client_Scanner.html)
    - Allows a user/customer to scan a product QR code using a camera.
    - Fetches and displays the product name and price dynamically.
 
2. Admin Panel (Admin_Panel.html)
    - Supports adding, deleting, and viewing product listings.
    - Displays live statistics such as total products and last update date.
  
3. Server-side API (api.php)
    - Handles requests between the client and admin interfaces.
    - Provides endpoints for:
      - ?action=scan&qr_code → Fetch product data
      - ?action=add → Add a new product
      - ?action=delete → Delete a product
      - ?action=products → List all 
      

Can be deployed under IIS or any PHP-capable web server.
