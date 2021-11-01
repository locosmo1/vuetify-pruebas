using System.Data.SqlClient;
using System.Text;


public partial class conexion
{

    static string conexionString;

    private static void conectar()
    {
        conexionString = "server=151.106.97.153; database=u333469926_consultasvuejs; Integrated Security=True";
        SqlConnection conexion = new SqlConnection(conexionString);
        conexion.Open();
        MessageBox.Show("Conexion exitosa");
        conexion.Close();
    }

    private static desconectar()
    {
        conexion.Close();
        MessageBox.Show("Se ah desconectado correctamente");
    }
}

