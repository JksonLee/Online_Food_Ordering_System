<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:output method="html" doctype-public="XHTML/1.0 Transitional" 
              doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>

  <xsl:template match="/">
    <html>
      <head>
        <title>Dishes with Ratings and Reviews</title>
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
        <h2>Dishes with Ratings and Reviews</h2>
        <table>
          <tr>
            <th>SL</th>
            <th>Dish Image</th>
            <th>Dish Name</th>
            <th>Dish Price</th>
            <th>Customer Email</th>
            <th>Rating</th>
            <th>Review</th>
            <th>Review Timestamp</th>
          </tr>

          <xsl:apply-templates select="ratings/rating">
            <xsl:sort select="rating" order="descending" data-type="number"/>
          </xsl:apply-templates>
        </table>
      </body>
    </html>
  </xsl:template>

  <xsl:template match="rating">
    <tr>
      <!-- Apply highlight-text class if rating is greater than or equal to 4 -->
      <xsl:attribute name="class">
        <xsl:choose>
          <xsl:when test="number(rating) &gt;= 4">highlight-text</xsl:when>
          <xsl:otherwise></xsl:otherwise>
        </xsl:choose>
      </xsl:attribute>
      <td><xsl:value-of select="position()"/></td>
      <td><img src="{dish_image}" alt="Dish Image" width="100"/></td>
      <td><xsl:value-of select="dish_name"/></td>
      <td><xsl:value-of select="concat('Full: ', full_price, ' / Half: ', half_price)"/></td>
      <td><xsl:value-of select="customer_email"/></td>
      <td>
        <xsl:variable name="ratingColor">
          <xsl:choose>
            <xsl:when test="number(rating) &gt; 4">green</xsl:when>
            <xsl:otherwise>red</xsl:otherwise>
          </xsl:choose>
        </xsl:variable>
        <span style="color: {ratingColor};"><xsl:value-of select="rating"/></span>
      </td>
      <td><xsl:value-of select="review"/></td>
      <td><xsl:value-of select="review_timestamp"/></td>
    </tr>
  </xsl:template>
</xsl:stylesheet>
