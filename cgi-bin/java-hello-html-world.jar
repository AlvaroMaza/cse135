public class Main {
    public static void main(String[] args) {
        System.out.print("Cache-Control: no-cache\n");
        System.out.print("Content-type: text/html\n\n");
        System.out.print("<html>");
        System.out.print("<head>");
        System.out.print("<title>Hello, Perl!</title>");
        System.out.print("</head>");
        System.out.print("<body>");

        System.out.print("<marquee>Wow!</marquee>");
        System.out.print("<h1 align=\"center\">cse135Spain was here - Hello, Perl!</h1>");
        System.out.print("<hr>");
        System.out.print("<p>This page was generated with the Perl programming langauge</p>");

        String date = java.time.LocalDateTime.now().toString();
        System.out.printf("<p>Current Time: %s</p>\n", date);

        // IP Address is an environment variable when using CGI
        String address = System.getenv("REMOTE_ADDR");
        System.out.printf("<p>Your IP Address: %s</p>\n", address);

        System.out.print("</body>");
        System.out.print("</html>");
    }
}
