To make it work correctly I installed the deepseek-r1 version with the commands below:
curl -fsSL https://ollama.ai/install.sh | bash
ollama run deepseek-r1

![Celi AI Deep Seek](https://drive.google.com/file/d/17KO6GDIriYvEPHNmuz37tukgUHoxRnZn/view?usp=sharing)

I installed it using a Tesla H100 (any video card can be used) on Ubuntu 22.04 via Windows 11's WSL (which works perfectly). To allow access to the WSL localhost, use the following commands:

netsh interface portproxy add v4tov4 listenaddress=0.0.0.0 listenport=11434 connectaddress=127.0.0.1 connectport=11434
netsh advfirewall firewall add rule name="Abrir Porta 11434" dir=in action=allow protocol=TCP localport=11434

Use Xampp and run the api.php page on your server. It will work perfectly on localhost:11434

Bitcoin donations: 1DiegoU6ETJXK9hNWVTeuK4Y8fkksPnEnK
USDT donations: 0x1CE864dF66B44B22F22605b366Da928315A1ce17
