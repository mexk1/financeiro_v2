import React, { HTMLAttributes, PropsWithChildren, useRef } from "react"
import useModalControls from "../hooks/useModalControls"

const wrapperClasses = [
  "fixed ",
  "overflow-auto" ,
  "flex items-center ",
  "justify-center"  ,
  "bg-black bg-opacity-50" ,
  "top-0",
  "left-0" ,
  "w-screen",
  "h-screen",
  'z-10',
  'transition',
  'transition-all',
  'duration-300'
]

const contentClasses = [
  'z-10',
  'bg-white',
  'flex',
  'rounded-md',
  'shadow ',
  'shadow-primary-light',
  'items-center',
  'justify-center',
  'relative'
]

const Modal = ( { children, onClose, onOpen, isOpen: parentIsOpen, trigger: Trigger }:ModalProps ) => { 
  
  const { open, close, isOpen } = useModalControls( { 
    defaultOpen: parentIsOpen,
    onClose: onClose,
    onOpen: onOpen
  } )

  const contentRef = useRef<HTMLDivElement>( null )

  const TriggerComponent = () => (
    <>
      {
        Trigger && React.cloneElement( <Trigger />, { 
          onClick: open
        } )
      }
    </>
  )

  return ( 
    <>
      <TriggerComponent  />
      <div className={ wrapperClasses.join(' ') + ( isOpen ? ' max-h-screen max-w-screen' : 'max-w-0 max-h-0' ) }>
        <div ref={ contentRef } className={ contentClasses.join(' ') } style={{minWidth: 200, minHeight: 200 }}>
          <div onClick={ close } className="absolute z-10 top-1 right-2" > X </div>
          {children} 
        </div>
      </div>
    </>
  )
}

export interface ModalProps extends PropsWithChildren<{}> {
  onClose?: ( ) => void,
  onOpen?: ( ) => void,
  dismissable?: boolean,
  isOpen?: boolean,
  trigger?: ( props?:HTMLAttributes<any> ) => JSX.Element
}
export default Modal