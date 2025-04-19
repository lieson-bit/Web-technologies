import os
import sys
from http.server import HTTPServer, CGIHTTPRequestHandler

class MyCGIHandler(CGIHTTPRequestHandler):
    cgi_directories = ["/cgi-bin"]  # Ensure this is correctly set

# Set the web directory and port
webdir = '.'  
port = 8081     

if len(sys.argv) > 1:
    webdir = sys.argv[1]  
if len(sys.argv) > 2:
    port = int(sys.argv[2])  

print(f"Web directory: {webdir}, Port: {port}")

os.chdir(webdir)  # Change to web directory

server_address = ('', port)
httpd = HTTPServer(server_address, MyCGIHandler)  # Use the custom handler
print(f"Server running on port {port}...")
httpd.serve_forever()
