<table>
    <tr>
        <th>Nombre</th>
        <td> @php echo $_name_project @endphp </td>
    </tr>
    @if (isset($_nit))
        <tr>
            <th>NIT</th>
            <td> @php echo $_nit @endphp </td>
        </tr>
   {{--       <tr>
            <th>Sector económico</th>
        </tr>  --}}
    @endif
    <tr>
        <th>Ciudad</th>
        <td> @php echo $_city @endphp </td>
    </tr>
    <tr>
        <th>Macrosector-Microsector</th>
        <td> @php echo $_category_name @endphp </td>
    </tr>
    @if (isset($_nit))
        <tr>
            <th>Fecha de constitución</th>
            <td> @php echo $_date_init_project @endphp </td>
        </tr>
    @endif
    <tr>
        <th>Página web</th>
        <td> @php echo $_web @endphp </td>
    </tr>
    <tr>
        <th>Correos de contacto</th>
        <td> @php echo $_emails_contacts @endphp </td>
    </tr>
    <tr>
        <th>Descripción del proyecto</th>
        <td> @php echo $_project_description @endphp </td>
    </tr>
</table>