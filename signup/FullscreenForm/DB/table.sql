#
#  Tabela estrutural do serviço de cadastro e reserva - Mostra de Cinema do Instituto Federal Fluminense
#
#  Disponibilizado sob a licença GNU GPL (GNU Public License - http://www.gnu.org/licenses/gpl.html)

DROP DATABASE IF EXISTS cadastro;
CREATE DATABASE cadastro;
use cadastro;
DROP TABLE IF EXISTS reserva;
CREATE TABLE reserva(
		matricula 				INT(20) NOT NULL,
		nome 					varchar(30) NOT NULL,
		email 					varchar(30) NOT NULL,
		dataNasc 				varchar(30) NOT NULL,
        sessao					varchar(100) NOT NULL,
		primary key(matricula)
)DEFAULT CHARSET=utf8;
