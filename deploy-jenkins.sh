 #!/bin/bash
 set -e
sudo apt-get update
sudo ufw allow 22
sudo ufw reload
echo "** Install Jenkins **"
sudo apt-get install -y fontconfig openjdk-17-jre
curl -fsSL https://pkg.jenkins.io/debian/jenkins.io.key | sudo tee \
  /usr/share/keyrings/jenkins-keyring.asc > /dev/null
echo deb [signed-by=/usr/share/keyrings/jenkins-keyring.asc] \
  https://pkg.jenkins.io/debian binary/ | sudo tee \
  /etc/apt/sources.list.d/jenkins.list > /dev/null
sudo apt update
sudo apt install -y jenkins
sudo systemctl start jenkins
sudo systemctl enable jenkins

echo "** Install Docker **"
sudo apt-get install -y docker.io
sudo usermod -aG docker jenkins
sudo systemctl restart docker
sudo systemctl restart jenkins
echo "** Installing git **"
sudo apt-get install -y git

echo "** Installing Google Cloud SDK **"
echo "deb [signed-by=/usr/share/keyrings/cloud.google.gpg] https://packages.cloud.google.com/apt cloud-sdk main" | sudo tee -a /etc/apt/sources.list.d/google-cloud-sdk.list
sudo apt-get update -y && sudo apt-get install -y google-cloud-sdk      
sudo apt-get install -y google-cloud-sdk-gke-gcloud-auth-plugin
sudo apt-get install -y kubectl

sudo apt install unzip
sudo apt install -y python3-pip

sudo pip3 install selenium
sudo pip3 install pytest
sudo pip3 install webdriver-manager
sudo apt-get install -y chromium-chromedriver
sudo apt install -y google-chrome-stable


sudo apt-get update
sudo apt-get install -y unzip openjdk-8-jre-headless xvfb libxi6 libgconf-2-4


sudo apt-get install -y python3-pip
sudo pip3 install --upgrade pip
sudo pip3 install selenium requests beautifulsoup4



sudo curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
sudo systemctl restart jenkins


