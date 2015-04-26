<%
dim fname,city
fname=request.form("name22")
city=request.form("city")
response.write("Dear " & fname & ". ")
response.write("Hope you live well in " & city & ".")
%>