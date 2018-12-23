<?xml version="1.0" encoding="UTF-8"?>
<xsl:transform  version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/">
        <html>
            <body>
                <h2>Tabla preguntas</h2>
                <table border="1">
                    <tr bgcolor="#9acd32">
                        <th style="text-align:left">Pregunta</th>
                        <th style="text-align:left">Respuesta correcta</th>
                        <th style="text-align:left">Respuestas incorrectas</th>
                    </tr>
                    <xsl:for-each select="assessmentItems/assessmentItem">
                        <tr>
                            <td><xsl:value-of select="itemBody/p"/></td>
                            <td><xsl:value-of select="correctResponse/value"/></td>
                            <td><xsl:value-of select="incorrectResponses"/></td>
                        </tr>
                    </xsl:for-each>
                </table>
            </body>
        </html>
    </xsl:template>
</xsl:transform >

