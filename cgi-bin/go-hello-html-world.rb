#!/usr/bin/env go

package main

import (
    "fmt"
    "net/http"
    "os"
    "time"
)

func main() {
    t := time.Now()

    // Print HTML header
    fmt.Print("Cache-Control: no-cache\n")
    fmt.Print("Content-type: text/html\n\n")
    fmt.Print("<html><head><title>Hello CGI World</title></head><body><h1 align=center>Hello HTML World</h1><hr/>\n")

    fmt.Print("Hello World<br/>\n")
    fmt.Printf("This program was generated at: %s\n<br/>", t.Format(time.RFC1123Z))
    fmt.Printf("Your current IP address is: %s<br/>", os.Getenv("REMOTE_ADDR"))

    // Print HTML footer
    fmt.Print("</body></html>")
}
