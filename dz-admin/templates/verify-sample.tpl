<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<!-- This is the smarty template that goes with QfSmarty.php
     Return to the tutorial index to see a demonstration of what this does.

     Copyright (c) 2005, 2009, Parliament Hill Computers (www.phcomp.co.uk). Author: Alain D D Williams (addw@phcomp.co.uk).
     You may used this file as the basis your own (or organisation's/company's) project (under whatever
     licence that you see fit), but may not claim ownership or copyright of the substantially unmodified file.
     This file is made available in the hope that it is useful, there is no warranty at all, use at your own risk.

     SCCS: @(#)QfSmarty.tpl	1.2 12/29/09 14:12:37
 -->
<html>
 <head>
  <title>Smarty template demonstration</title>
  <link rel="stylesheet" type="text/css" href="/style.php">

 {* Emit any javascript from quickform *}
 {if $FormData.javascript}
     {$FormData.javascript}
 {/if}
 </head>
 <body>

  <!-- A standard page header -->
  <div style='position : absolute;text-align: left;top:10px;'>
   <a href='/'><img src='/images/kite_40_83_trans.gif' width="40" height="83" alt="Parliament Hill Computers Ltd" style="border-width: 0;"></a>
  </div>
  <div style='top:0px;margin:0px auto;text-align: center; font-size:40pt; '>
   {$FormData.header.DemoHeader}
  </div>
  <p>

  <!-- The date and time substitution on the line below is done entirely in smarty -->
  The current date and time is {$smarty.now|date_format:"%Y-%m-%d %H:%M:%S"}
  <p>

   <!-- The form attributes are: is it a GET or POST form, the URL to action -->
   <form {$FormData.attributes}>
   <input type="hidden" name="amod" value="{$smarty.request.amod}">
   <input type="hidden" name="atask" value="{$smarty.request.atask}">
   <input type="hidden" name="task" value="{$smarty.request.task}">
     {$FormData.hidden}
     <table>
       <tr>
         <!-- Each field has attributes incuding: name, value, type, html, label
              The attribute 'error' will be set if the 'group_errors' option is false - and there is an error!
           -->
         <th>{if $FormData.Title.required}<font color="red">*</font> {/if}{$FormData.Title.label}</th>
         <td>{$FormData.Title.html}</td>
       </tr>
       <tr>
         <th>{if $FormData.FirstName.required}<font color="red">*</font> {/if}{$FormData.FirstName.label}</th>
         <td>{$FormData.FirstName.html}</td>
         <th>{if $FormData.LastName.required}<font color="red">*</font> {/if}{$FormData.LastName.label}</th>
         <td>{$FormData.LastName.html}</td>
       </tr>
       <tr>
         <th>{if $FormData.Age.required}<font color="red">*</font> {/if}{$FormData.Age.label}</th>
         <td>{$FormData.Age.html}</td>
         <th>{if $FormData.Telephone.required}<font color="red">*</font> {/if}{$FormData.Telephone.label}</th>
         <td>{$FormData.Telephone.html}</td>
       </tr>
       <!-- Display the buttons -->
       <tr>
         <td><br></td>
         <td align="center">
           {$FormData.Clear.html}&nbsp;{$FormData.Submit.html}
         </td>
       </tr>
    </table>
   </form>

   {if $FormData.requirednote and not $FormData.frozen}
     {$FormData.requirednote}
   {/if}

   <!-- Display any errors, loop over what there is in the errors array. The key is the field name.
        This will only contain something if the 'group_errors' option is true - and there is an error!
     -->
   <div style="color:red">
    {foreach from=$FormData.errors item=error key=field_name}
      {$error}<br>
    {/foreach}
   </div>

  <p>
   This is a simple form, fill in some values and press <i>Submit</i>.
  <p>
   This is a quickform that has been rendered with smarty.
  <p>
   There is some validation on this form:
  <ul>
   <li> Firstname: client side: it must have a value: the value 'Bill' or 'John'
   <li> Lastname: client side: it must have a value
   <li> Age: client side: it must have a value and be numeric
   <li> Telephone: client side: it must start '0' or '+'
  </ul> 

  <p style="font-size: x-large; font-weight: bold;">
   Return to this <em><a href='index.php'>tutorial index</a></em>.
  </p>
 </body>
</html>
