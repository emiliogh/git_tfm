pipeline {
    agent {
        label 'agente-ansible'
    }
    stages {
		// etapa 1: Origen del código de la aplicación a desplegar
        stage('Source') {
            steps {
                git 'https://github.com/emiliogh/git_tfm.git'
            }
        }
		// etapa 2 : Pruebas unitarias
        stage ('Ejecutar pruebas unitarias'){
            steps {
                sh 'cd src && ./vendor/bin/phpunit tests'
            }
        }
        stage('Validar conexión ansible') {
            steps {
                echo "validar conexión ansible controlador con nodo"
				sshPublisher(publishers:
				[sshPublisherDesc(
				    configName:'AnsibleController',
					transfers: [
					    sshTransfer(
						cleanRemote:false,
						execCommand:'ansible-playbook playbook_ping.yml --limit nodo_prueba',
						execTimeout:120000
						)
					],
					usePromotionTimestamp: false,
					useWorkspaceInPromotion: false,
					verbose: false)
				])
            }
        }
    }
}
