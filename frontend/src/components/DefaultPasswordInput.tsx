import React, { ChangeEvent, useCallback, useState } from "react"
import DefaultInput, { classes as DefaultInputClasses } from "./DefaultInput"
import { BiHide, BiShow } from 'react-icons/bi'

const DefaultPasswordInput = ( { name }:{name?:string} ) => {

  const [ show, setShow ] = useState(false)
  const [ value, setValue ] = useState<string>('')

  const toggleShow = useCallback( () => {
    setShow( show => !show )
  }, [] )

  const handleChange = useCallback( ( e:ChangeEvent<HTMLInputElement> ) => {
    setValue( e.target.value )
  }, [] )

  return (
    <div className={`${DefaultInputClasses} flex items-center justify-between`}>
      <input type="hidden" value={value} readOnly />
      <div className="flex-1">
        {
          show && 
            <input type="text" value={value} readOnly className="focus:outline-none w-full" />
        }
        <DefaultInput 
          type="password"
          value={ value }
          name={ name }
          onChange={ handleChange }
          className={`focus:outline-none w-full ${show ? 'hidden' : '' }`} 
          />
      </div>
      <div onClick={ toggleShow } className="pl-2 border-l border-l-border ">
        { show
          ? <BiHide />
          : <BiShow />
        }
      </div>
    </div>
  )
}

export default DefaultPasswordInput