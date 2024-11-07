<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <!-- Define the HTML template -->
    <xsl:template match="/">
        <html>
            <head>
                <title>Payment Data</title>
                <style>
                     body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f9f9f9;
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
            text-align: center;
          }
          tr:nth-child(even) {
            background-color: #f2f2f2;
          }
          tr:hover {
            background-color: #e0e0e0;
          }
          .highlight-text {
            color: red;
          }
                </style>
            </head>
            <body>
                <h1>Payment Data</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Payment ID</th>
                            <th>Payment Type</th>
                            <th>Order ID</th>
                            <th>Total Amount</th>
                            <th>Customer ID</th>
                            <th>Customer Name</th>
                            <th>Customer Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Iterate through each payment with sorting -->
                        <xsl:for-each select="payments/payment">
                            <xsl:sort select="order_total" data-type="number" order="descending"/>
                            <tr>
                                <!-- Conditional styling for cells -->
                                <td><xsl:value-of select="payment_id"/></td>
                                <td><xsl:value-of select="payment_type"/></td>
                                <td><xsl:value-of select="order_id"/></td>
                                <td>
                                    <xsl:choose>
                                        <xsl:when test="order_total > 1000">
                                            <span class="highlight-text">
                                                <xsl:value-of select="order_total"/>
                                            </span>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <xsl:value-of select="order_total"/>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </td>
                                <td><xsl:value-of select="customer_id"/></td>
                                <td><xsl:value-of select="customer_name"/></td>
                                <td><xsl:value-of select="customer_email"/></td>
                            </tr>
                        </xsl:for-each>
                    </tbody>
                </table>
            </body>
        </html>
    </xsl:template>

</xsl:stylesheet>
