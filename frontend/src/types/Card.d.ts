export type Card = {
  id: number,
  name: string,
  last_digits?: string,
  mode?: "debit" | "credit" | "both" ,
  bill_close_day: number,
}