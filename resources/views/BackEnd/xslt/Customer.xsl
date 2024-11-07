<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

  <!-- Output HTML with proper doctype for XHTML -->
  <xsl:output method="html" doctype-public="XHTML/1.0 Transitional" 
              doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>

  <xsl:param name="currentDate"/>
  <xsl:param name="generatedDate"/>

  <!-- Root template -->
  <xsl:template match="/">
    <html>
      <head>
        <title>Customer Table</title>
        <style>
          body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f9f9f9;
          }
          h2 {
            color: #333;
            text-align: center;
          }
          table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
          }
          th, td {
            border: 1px solid black;
            padding: 12px;
            text-align: left;
          }
          th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            text-align: center;
          }
          td {
            text-align: center;
          }
          .highlight {
            background-color: yellow;
          }
          tr:nth-child(even) {
            background-color: #f2f2f2;
          }
          tr:hover {
            background-color: #e0e0e0;
          }
        </style>
      </head>
      <body>
        <h2>Customer List</h2>

        <!-- Inject the generated date from PHP -->
        <p>Generated on: <xsl:value-of select="$generatedDate"/></p>

        <table>
          <tr>
            <th>Customer ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone No</th>
            <th>Created At</th>
          </tr>

          <!-- Sort by created_at field in ascending order -->
          <xsl:apply-templates select="customers/customer">
            <xsl:sort select="created_at" order="ascending" data-type="text"/>
          </xsl:apply-templates>

        </table>
      </body>
    </html>
  </xsl:template>

  <!-- Template for each customer row -->
  <xsl:template match="customer">
    <tr>
      <!-- Conditional styling: highlight rows for specific conditions -->
<xsl:if test="contains(created_at, $currentDate)">
        <xsl:attribute name="class">highlight</xsl:attribute>
      </xsl:if>
      <td><xsl:value-of select="customer_id"/></td>
      <td><xsl:value-of select="name"/></td>
      <td><xsl:value-of select="email"/></td>
      <td><xsl:value-of select="phone_no"/></td>
      <td><xsl:value-of select="created_at"/></td>
    </tr>
  </xsl:template>

</xsl:stylesheet>
