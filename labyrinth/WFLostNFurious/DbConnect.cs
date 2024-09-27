using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Net;
using System.Net.Sockets;
using System.Text;
using System.Threading;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.Diagnostics;
using System.Xml.Linq;
using Newtonsoft.Json.Linq;
using System.IO;
using System.Xml;
using System.Xml.Serialization;
using MySql.Data.MySqlClient;






/*using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;*/





namespace WFLostNFurious
{
    class DbConnect
    {
        private MySqlConnection connection;
        private string server;
        private string database;
        private string uid;
        private string password;
        
        
        //Constructor
        public DbConnect()
        {
            Initialize();
            
            
        }

        //Initialize values
        private void Initialize()
        {
            //Comme dans pdo on rentre les info pour se conneter à la dataBase, Nom de base, mot depasse , pseudo...
            server = "localhost";
            database = "escapegame_2021";
            uid = "root";
            password = "";
            string connectionString;
            connectionString = "SERVER=" + server + ";" + "DATABASE=" +
            database + ";" + "UID=" + uid + ";" + "PASSWORD=" + password + ";";

            connection = new MySqlConnection(connectionString);
           // MessageBox.Show("Bienvenue");

        }

        //open connection to database
        public bool OpenConnection()
        {
            try
            {
                // MessageBox.Show("testOpenConnection"); 
                connection.Close();
                connection.Open();
                return true;
            }
            catch (MySqlException ex)
            {
                //When handling errors, you can your application's response based 
                //on the error number.
                //The two most common error numbers when connecting are as follows:
                //0: Cannot connect to server.
                //1045: Invalid user name and/or password.
                switch (ex.Number)
                {
                    case 0:
                        MessageBox.Show("Cannot connect to server.  Contact administrator");
                        break;

                        

                    case 1045:
                        MessageBox.Show("Invalid username/password, please try again");
                        break;
                }
                return false;
            }
        }

        //Close connection
          private bool CloseConnection()
          {
        try
      {
          connection.Close();
          return true;
      }
      catch (MySqlException ex)
      {
          MessageBox.Show(ex.Message);
          return false;
      }
          }

        //Select statement
        public string Select()
        {


            string query = "SELECT en2 FROM solution where jour = ' " + Jeu.RecupDate() + "' " ;

            //Create a list to store the result


            //Open connection
            if (this.OpenConnection() == true)
            {
                //Create Command
                MySqlCommand cmd = new MySqlCommand(query, connection);
                //Create a data reader and Execute the command
                MySqlDataReader dataReader = cmd.ExecuteReader();
                string en2 = "";
             //   int test = 12;
              //  test = test / 0;
                

                //Read the data and store them in the list
                while (dataReader.Read())
                {
                     en2 = dataReader["en2"] + "";
                }

                //close Data Reader
                dataReader.Close();

                //close Connection
                this.CloseConnection();

                //return list to be displayed

                if(en2 == String.Empty)
                {
                    return Jeu.CODE_DE_BASE;
                }
                else
                {
                    return en2;
                }
                
            }
            else
            {
               // MessageBox.Show("testOpen2");
                return "Non connecter a la database";
            }
        }

        //Count statement
       /* public int Count()
        {
        }*/

        //Backup
        public void Backup()
        {
        }

        //Restore
        public void Restore()
        {
        }
    }
}
