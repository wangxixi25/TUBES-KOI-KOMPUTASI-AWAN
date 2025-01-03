pipeline {
    agent any
    environment {
        PATH = "/usr/local/bin:/opt/homebrew/bin:/usr/bin:/bin:$PATH"
    }
    stages {
        stage('Check Docker Path') {
            steps {
                sh 'echo $PATH'  // Menampilkan PATH di Jenkins
                sh 'which docker'  // Memeriksa lokasi Docker
            }
        }
        stage('Check Docker Version') {
            steps {
                sh 'docker --version'  // Menampilkan versi Docker
            }
        }
    }
}
