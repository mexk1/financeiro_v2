import React, { HTMLAttributes, PropsWithChildren } from "react"

const DefaultForm = React.forwardRef<HTMLFormElement, Props>( ( { 
  submitButton,
  children, 
  ...props 
}, ref ) => {

  return ( 
    <form 
      ref={ ref  }
      className="flex flex-col gap-4 items-center justify-center bg-white rounded-md w-11/12 py-8 px-4"
      { ...props }
    >
      <div className="flex-1 w-full">
        { children }
      </div>
      <div className="flex items-center justify-center">
        { submitButton ?? 
          <input
            type="submit"
            className="bg-primary-default px-4 py-2 rounded text-white font-bold "
          />
        }
      </div>
    </form>
  )
})


interface Props extends PropsWithChildren<HTMLAttributes<HTMLFormElement>> {
  submitButton?: JSX.Element
}

export default DefaultForm