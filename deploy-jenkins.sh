 #!/bin/bash
 set -e
sudo apt-get update
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

echo "** Installing git **"
sudo apt-get install -y git

echo "** Installing Google Cloud SDK **"
echo "deb [signed-by=/usr/share/keyrings/cloud.google.gpg] \
  http://packages.cloud.google.com/apt cloud-sdk main" | sudo tee \
  -a /etc/apt/sources.list.d/google-cloud-sdk.list
sudo apt-get update && sudo apt-get install -y google-cloud-sdk      
sudo apt-get install google-cloud-sdk-gke-gcloud-auth-plugin
