<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  
  <!-- Output HTML -->
  <xsl:output method="html" doctype-public="XHTML/1.0 Transitional" 
              doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>

  <!-- Template matching the root element -->
  <xsl:template match="/">
    <html>
      <head>
        <title>Order Table</title>
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
          tr:nth-child(even) {
            background-color: #f2f2f2;
          }
          tr:hover {
            background-color: #e0e0e0;
          }
          .high-value {
            background-color: yellow;
          }
        </style>
      </head>
      <body>
        <h2>Orders</h2>
        <table>
          <thead>
            <tr>
              <th>SL</th>
              <th>Customer Name</th>
              <th>Order Total</th>
              <th>Order Status</th>
              <th>Order Date</th>
              <th>Payment Type</th>
              <th>Payment Status</th>
            </tr>
          </thead>
          <tbody>
            <xsl:apply-templates select="orders/order">
              <xsl:sort select="order_total" data-type="number" order="descending"/>
            </xsl:apply-templates>
          </tbody>
        </table>
      </body>
    </html>
  </xsl:template>

  <!-- Template for each order row -->
  <xsl:template match="order">
    <tr>
      <!-- Conditional class assignment for high-value orders -->
      <xsl:choose>
        <xsl:when test="order_total > 200">
          <xsl:attribute name="class">high-value</xsl:attribute>
        </xsl:when>
      </xsl:choose>
      <td><xsl:value-of select="order_id"/></td>
      <td><xsl:value-of select="customer_name"/></td>
      <td><xsl:value-of select="order_total"/></td>
      <td><xsl:value-of select="order_status"/></td>
      <td><xsl:value-of select="order_date"/></td>
      <td><xsl:value-of select="payment_type"/></td>
      <td><xsl:value-of select="payment_status"/></td>
    </tr>
  </xsl:template>

</xsl:stylesheet>
