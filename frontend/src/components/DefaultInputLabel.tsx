import {  DetailedHTMLProps } from "react"

const DefaultInputLabel = ({ children, label, ...props }: Props) => {

  return (
    <label 
      className="flex flex-col items-start justify-start w-full" 
      { ...props} 
    >
      <span className="my-2 text-gray-400">
        {label}
      </span>
      {children}
    </label>
  )
}


interface Props extends Partial<DetailedHTMLProps<{}, HTMLLabelElement>> {
  label: string,
  children?: JSX.Element
}

export default DefaultInputLabel