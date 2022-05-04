import React, { DetailedHTMLProps } from "react"

export const classes = "w-full focus-within:outline-none border border-border px-2 py-1 rounded focus:shadow-md"


const DefaultInput = React.forwardRef<HTMLInputElement, Props>( ( { ref: propsRef, ...props }, ref ) => {
  return (
    <input 
      ref={ propsRef ?? ref }
      className={classes}
      { ...props }
    />
  )
})

interface Props extends Partial<DetailedHTMLProps<any, HTMLInputElement>> {}

export default DefaultInput