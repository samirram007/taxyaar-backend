# Ticketing System Design Notes

## 1. Overview

A ticketing system for tax-related support where customers can raise tickets categorized as:

* Complaint
* Query
* Request

Tickets are handled by customer support agents, assigned based on workload and availability. The system supports document exchange, internal/external communication, escalation, and SLA-driven monitoring.

---

## 2. Ticket Lifecycle (State Machine)

### States

* **OPEN** → Ticket created, not yet assigned
* **ASSIGNED** → Owner assigned, work not started
* **IN_PROGRESS** → Actively being worked
* **WAITING_FOR_CUSTOMER** → Awaiting user input/documents
* **WAITING_FOR_INTERNAL** → Awaiting internal team/system
* **ON_HOLD** → Temporarily paused
* **ESCALATED** → Raised to higher authority
* **RESOLVED** → Solution provided
* **CLOSED** → Completed, no further action
* **REOPENED** → Customer not satisfied
* **CANCELLED** → Invalid or withdrawn

### Rules

* Default state: **OPEN**
* Tickets in **OPEN** cannot be updated until assigned
* Transition example:

  ```
  OPEN → ASSIGNED → IN_PROGRESS → RESOLVED → CLOSED
  ```
* Reopen flow:

  ```
  CLOSED → REOPENED → ASSIGNED → IN_PROGRESS
  ```

---

## 3. Ticket Status Table (`ticket_statuses`)

Fields:

* `name`
* `alias`
* `is_public` (hide internal statuses from customers)
* `description`
* `display_order`
* `is_active`
* `color_code`

---

## 4. Ticket Type

Defines the purpose/story of the ticket:

* Why the ticket was raised
* Context for handling
* Used for classification and routing

---

## 5. Ticket Handling Flow

1. Ticket raised by customer
2. Reaches backend system
3. Assigned to support agent
4. Agent reads and updates status
5. Resolution paths:

   * Direct resolution → mark as **RESOLVED**
   * Needs documents → request upload → move to **WAITING_FOR_CUSTOMER**
6. Communication via messages
7. Closure:

   * If customer satisfied → **CLOSED**
   * If not satisfied → **REOPENED** or **ESCALATED**

---

## 6. Document Management

* Supports document uploads
* Versioning enabled:

  * Multiple uploads for same document
  * Identified via file names
* Used in cases where additional proof/input is required

---

## 7. SLA Policies

SLA policies act as **system-driven monitoring agents** evaluating ticket states continuously.

### Example Policies

#### Open Ticket SLA

* `name`: Open ticket SLA
* `code`: OTS001
* `description`: Ticket remains in OPEN state too long
* `first_response_minute`: 120
* `resolution_time`: -1
* `is_active`: false

#### Assigned Ticket SLA

* `name`: Assigned
* `code`: ASSIGN001
* `description`: Ticket inactive after assignment
* `first_response_minute`: 60
* `paused_at`: stored in ticket/ticket_event
* `pause_duration`: stored in ticket/ticket_event
* `resolution_time`: -1
* `is_active`: false

#### Escalated Ticket SLA

* `name`: Escalated ticket SLA
* `code`: ESC001
* `description`: Escalated ticket not handled timely
* `first_response_minute`: 20
* `resolution_time`: 40
* `is_active`: false

---

## 8. SLA Engine Behavior (Agent-Based Processing)

### Continuous Monitoring Logic

1. Check for OPEN tickets:

   * If not assigned within 120 minutes → SLA breach
   * If within limit → attempt assignment

2. Assignment Logic:

   * Identify available support agents
   * Assign ticket automatically

3. Post-Assignment Monitoring:

   * If no activity for 60 minutes → trigger alert
   * If still inactive → escalate alerts progressively:

     * Next alert after +2 minutes
     * Continue until action taken

4. Event-Based Tracking:

   * Monitor ticket events (status updates, messages)
   * Detect inactivity gaps

---

## 9. Escalation Logic

* Customer can escalate after closure
* Escalated tickets:

  * Trigger immediate SLA checks
  * Notify assigned agent
  * If no response → escalate to admin
* Admin capabilities:

  * Reassign ticket
  * Override ownership
  * Force actions

---

## 10. Working Hours & Holiday Handling

* SLA engine respects:

  * Business hours
  * Holiday calendar
* If ticket raised outside working window:

  * SLA timers paused
  * Resume on next working day (e.g., Monday after weekend)

---

## 11. Alerting System

* Alerts triggered when:

  * SLA breach detected
  * No activity within defined time window
* Alert escalation pattern:

  ```
  Initial Alert → +2 min → +2 min → escalate to admin
  ```

---

## 12. Key Design Principles

* State-driven system (finite state machine)
* Event-based tracking (ticket_event)
* SLA as background agent (not blocking operations)
* Separation of:

  * Customer-visible states
  * Internal workflow states
* Strong audit trail via events and document versions

---


ticket type is going to tell us about the story of ticket why ticket has been raised now when this story starts
note it

this sla_policies will work as an agent for the system which will be aware of every ticket state of this system

nope i want slas to be like

this sla_policies will work as an agent for the system which will be aware of every ticket state of this system

nope i want slas to be like

name : Open ticket SLA
code: OTS001
description: this ticket has been in opened state more than minutes
first_response_minute: 120 minutes
resolution_time: -1,
is_active: false,
--------------
name : Assigned
code: ASSIGN001
description: this ticket has been in assigend state more than minutes
first_response_minute: 60 minutes,
paused_at: 21:03, // will be in ticket master or ticket_event
pause_duration: 130 minutes, // will be in ticket master or ticket_event
resolution_time: -1,
is_active: false,

---------------
name : ESCALATED ticket SLA
code: ESC001
description: this ticket has been in ESCALATED state more than minutes
first_response_minute: 20 minutes
resolution_time: 40 minutes,
is_active: false,
but if not ticket is opened as it has to check ticket if open then if ticket not picked for 2 hours but if no ticket is opened then the checks will be expensive 
i want to run as an agent of the system this will run with a process
sla_policies checks happening tickets found open but not more than 2 hours so this policy has  not been breached but ticket is open now the system agent will run another check that who is open to receive this ticket now ticket is assigned 
it will again run a check for the status for sla_policies again now no ticket found then it will run a check for the highest ticket open hour means if the lastest which is suppose there is a ticket assigned and for the time crossed 60 minutes and for more than 5 minutes no event updated working in_progess or anything then it will alert the system about ticket and the alert will go to the support engineer solving the ticket if no event updated then the next alarm will be in * 2 minutes ,now if the ticket was raised on friday now this policies will also check the holiday and working hours calendar then rules have to be if the next day is not the day of working then policies have to hold for the next working day that can be monday but if user esclated the ticket then it will alert the support member again means checks for esclated ticket will happen and if it does not get response then it can go to admin for alert and knock then admin has the power to directly transfer any issue to any other member or can give the process permission of transfer the issue

note it

start taking note of sql tables now
ticket_statuses
name,
alias,
is_public, this is because if the status is waiting for internal and we don't want to show this to public then the 
description,
display_order,
is_active,
color_code,
if open is the status nothing can be updated till it is assigned to someone,
the default status has to be open
a ticket life cycle has to be OPEN ASSIGNED, further updates
OPEN → created, not yet picked
ASSIGNED → owner decided, work not started
IN_PROGRESS → actively being worked
WAITING_FOR_CUSTOMER → blocked by user input/docs
WAITING_FOR_INTERNAL → blocked by another team/system
ON_HOLD → paused (no immediate action expected)
ESCALATED → raised to higher level (still being worked)
RESOLVED → solution provided
CLOSED → finished, no further action
REOPENED → customer not satisfied / issue persists
CANCELLED → invalid / withdrawn
note it

this is about ticketing system
a system where tickets will be raised by customer here tickets can be a complaint, a query or a request, regarding tax now , the customer support employee that will be chosen to reply will be based on the tickets they have, these tickets is regarding taxes and tax filing support now
the process has to follow like ticket raised (query,complaint,request), reached to backend , now
customer support person reads status updated, now a support can solve the issue it self , if solves itself then he can only update the ticket status to be solved, if that ticket involves the documents, 
then a customer support needs the document to be re uploaded then they can have messages within them , or the customer if is not satisfied by the closure then it can escalate the ticket now the situation is this ticket is closed from the customer support side but the customer is not satisfied by the result .

Document uploads
will have documents and versioning as well because if new document is uploaded of same time
we will get document names through the file names


write some patterns state machine pattern for ticket life cycle
just note it down without any reply

