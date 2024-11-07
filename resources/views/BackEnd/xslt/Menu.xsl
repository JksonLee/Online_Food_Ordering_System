<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:output method="html" doctype-public="XHTML/1.0 Transitional" 
              doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>

  <xsl:template match="/">
    <html>
      <head>
        <title>Menu</title>
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
          .highlight {
            color: red;
          }
        </style>
      </head>
      <body>
        <h2>Menu</h2>
        <table>
          <tr>
            <th>SL</th>
            <th>Dish Name</th>
            <th>Category Name</th>
            <th>Dish Detail</th>
            <th>Full Price</th>
            <th>Half Price</th>
            <th>Dish Image</th>
            <th>Added On</th>
          </tr>

          <!-- Apply templates and sort dishes by dish name -->
          <xsl:apply-templates select="menu/dish">
            <xsl:sort select="dish_name" order="ascending"/>
          </xsl:apply-templates>
        </table>
      </body>
    </html>
  </xsl:template>

  <!-- Template for individual dish -->
  <xsl:template match="dish">
    <tr>
      <td>
        <xsl:choose>
          <xsl:when test="position() &gt; 5">
            <span class="highlight"><xsl:value-of select="position()"/></span>
          </xsl:when>
          <xsl:otherwise>
            <xsl:value-of select="position()"/>
          </xsl:otherwise>
        </xsl:choose>
      </td>
      <td>
        <xsl:choose>
          <xsl:when test="full_price &gt; 50">
            <span class="highlight"><xsl:value-of select="dish_name"/></span>
          </xsl:when>
          <xsl:otherwise>
            <xsl:value-of select="dish_name"/>
          </xsl:otherwise>
        </xsl:choose>
      </td>
      <td>
        <xsl:choose>
          <xsl:when test="full_price &gt; 50">
            <span class="highlight"><xsl:value-of select="category_name"/></span>
          </xsl:when>
          <xsl:otherwise>
            <xsl:value-of select="category_name"/>
          </xsl:otherwise>
        </xsl:choose>
      </td>
      <td>
        <xsl:choose>
          <xsl:when test="full_price &gt; 50">
            <span class="highlight"><xsl:value-of select="substring(dish_detail, 1, 50)"/>...</span>
          </xsl:when>
          <xsl:otherwise>
            <xsl:value-of select="substring(dish_detail, 1, 50)"/>...
          </xsl:otherwise>
        </xsl:choose>
      </td>
      <td>
        <xsl:choose>
          <xsl:when test="full_price &gt; 50">
            <span class="highlight"><xsl:value-of select="full_price"/></span>
          </xsl:when>
          <xsl:otherwise>
            <xsl:value-of select="full_price"/>
          </xsl:otherwise>
        </xsl:choose>
      </td>
      <td>
        <xsl:choose>
          <xsl:when test="full_price &gt; 50">
            <span class="highlight"><xsl:value-of select="half_price"/></span>
          </xsl:when>
          <xsl:otherwise>
            <xsl:value-of select="half_price"/>
          </xsl:otherwise>
        </xsl:choose>
      </td>
      <td>
        <xsl:choose>
          <xsl:when test="full_price &gt; 50">
            <span class="highlight">
              <xsl:choose>
                <xsl:when test="dish_image != ''">
                  <img src="{dish_image}" alt="Dish Image" width="100"/>
                </xsl:when>
                <xsl:otherwise>
                  No Image Available
                </xsl:otherwise>
              </xsl:choose>
            </span>
          </xsl:when>
          <xsl:otherwise>
            <xsl:choose>
              <xsl:when test="dish_image != ''">
                <img src="{dish_image}" alt="Dish Image" width="100"/>
              </xsl:when>
              <xsl:otherwise>
                No Image Available
              </xsl:otherwise>
            </xsl:choose>
          </xsl:otherwise>
        </xsl:choose>
      </td>
      <td>
        <xsl:choose>
          <xsl:when test="full_price &gt; 50">
            <span class="highlight"><xsl:value-of select="added_on"/></span>
          </xsl:when>
          <xsl:otherwise>
            <xsl:value-of select="added_on"/>
          </xsl:otherwise>
        </xsl:choose>
      </td>
    </tr>
  </xsl:template>
</xsl:stylesheet>
