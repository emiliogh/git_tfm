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
		// etapa 3: Validar conexión  ansible controlador - nodo
        stage('Validar conexión ansible controlador - nodo') {
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
		stage('Aprovisionamiento de host con Docker') {
            steps {
                echo "instalación de Docker en el host"
				sshPublisher(publishers:
				[sshPublisherDesc(
				    configName:'AnsibleController',
					transfers: [
					    sshTransfer(
						cleanRemote:false,
						execCommand:'ansible-playbook docker.yaml --limit nodo_prueba',
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
