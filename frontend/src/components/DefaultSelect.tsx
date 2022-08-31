import { isString } from "lodash"
import React from "react"
import { HTMLAttributes } from "react"

const DefaultSelect =  React.forwardRef<HTMLSelectElement, Props>( ({ options, value, onChange, defaultValue, ...rest }, ref ) => {

  const handleChange = ( value:any ) => {
    onChange && onChange( value )
  }

  return (
    <select ref={ref} { ...rest } >
      {
        options.map( o => (
          <option value={ isString( o.value ) ? o.value : JSON.stringify( o.value ) } >
            { o.label ?? o.value }
          </option>
        ))
      }
    </select>
  )
})


interface Option {
  label?: string,
  value: any
}
interface Props extends Partial<HTMLAttributes<HTMLSelectElement>> {
  options: Option[],
  value?: any,
  name?: string,
  onChange?: ( value: any ) => void
}

export default DefaultSelect